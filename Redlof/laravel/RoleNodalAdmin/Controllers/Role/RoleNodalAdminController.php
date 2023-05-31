<?php

namespace Redlof\RoleNodalAdmin\Controllers\Role;

use Illuminate\Http\Request;
//use Redlof\Auth\Classes\AuthHelper;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Models\UdiseNodal;
use Models\User;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleNodalAdmin\Controllers\Role\Requests\ChangePasswordRequest;
use Redlof\RoleNodalAdmin\Controllers\Role\Requests\DashboardInfoRequest;
use Redlof\RoleNodalAdmin\Controllers\Role\Requests\UdiseRequest;
use Redlof\RoleNodalAdmin\Controllers\Role\Requests\UpdateProfileRequest;
use Redlof\RoleNodalAdmin\Controllers\Role\RoleNodalAdminBaseController;

class RoleNodalAdminController extends RoleNodalAdminBaseController
{
    protected $user;

    public function __construct(UserRepo $user)
    {
        $this->user = $user;
        parent::__construct();
    }

    public function postChangePassword(ChangePasswordRequest $request)
    {

        $Msg = 'This is not your old password';
        $Status = Response::HTTP_UNPROCESSABLE_ENTITY;

        $user = $this->user->changePassword($request->all());

        if ($user) {
            $Msg = 'Successfull password change';
            $Status = Response::HTTP_OK;
        }

        $show['redirect'] = ['/nodaladmin/profile'];

        return api($Msg, $show);
    }

    public function postUpdateProfile(UpdateProfileRequest $request)
    {

        $Msg = 'Your profile details not updated successfully';
        $Status = Response::HTTP_UNPROCESSABLE_ENTITY;

        $user = User::where('id', \AuthHelper::getCurrentUser()->id)->update(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone' => $request->phone]);

        if ($user) {
            $Msg = 'Your profile details updated successfully';
            $Status = Response::HTTP_OK;
        }

        $show['redirect'] = ['/nodaladmin/profile'];

        return api($Msg, $show);
    }

    public function postUpdatePhoto(Request $request)
    {

        $user = \AuthHelper::getCurrentUser();

        $FileName = \ImageHelper::createFileName($request->photo);

        \ImageHelper::ImageUploadToS3($request->photo, $FileName, 'userphotos/', true, 100, 100);
        \UserHelper::updateFirstTimeUserPhoto($user->id, $FileName);

        $show['redirect'] = ['/nodaladmin/profile'];

        return api('Photo updated successfully', $show);
    }

    public function getAdminInformation()
    {
        $User = \AuthHelper::getCurrentUser();
        return response()->json(['data' => $User], 200);
    }

    public function getAdminDashboardInfo(DashboardInfoRequest $request)
    {

        $data = \AdminDashHelper::getDashboardData($request);

        $content['stats'] = \View::make('admin::role.dashboard-data1')->with('data', $data)->render();
        $content['lists'] = \View::make('admin::role.dashboard-data2')->with('data', $data)->render();

        return response()->json(['data' => $content, 'chartData' => $data], 200);
    }

    public function postAddUdise(UdiseRequest $request)
    {

        $request->merge([
            'email' => $this->state_nodal->user->email,
            'district_id' => $this->state_nodal->district->id,
        ]);

        UdiseNodal::updateOrCreate([
            'email' => $this->state_nodal->user->email,
            'district_id' => $this->state_nodal->district->id,
            'udise' => $request['udise'],
        ]);

        $udises = UdiseNodal::where('udise', $request['udise'])
            ->get();

        if (count($udises) > 1) {

            $ids = $udises->pluck('id');

            UdiseNodal::whereIn('id', $ids)->update(['status' => 'conflict']);
        }

        $reloadObj['reload'] = true;

        return api('Udise added successfully', $reloadObj);
    }

    public function postAddBulkUdise(Request $request)
    {

        if (!$request->hasFile('file')) {
            throw new ActionFailedException("Please upload csv file");
        }

        $file = $request->file('file');

        $users = \Excel::load($file)->get();

        foreach ($users as $key => $user) {

            if ($user->udise == null) {

                throw new ActionFailedException("Please check the csv file! It might be missing some fields. Please add all the information and try again later!");
            } else {

                UdiseNodal::updateOrCreate([
                    'email' => $this->state_nodal->user->email,
                    'district_id' => $this->state_nodal->district->id,
                    'udise' => $user->udise,
                ]);

                $udises = UdiseNodal::where('udise', $user->udise)
                    ->get();

                if (count($udises) > 1) {

                    $ids = $udises->pluck('id');

                    UdiseNodal::whereIn('id', $ids)->update(['status' => 'conflict']);
                }
            }
        }

        $showObject = [
            'reload' => true,
        ];

        return api('Uploaded successfully', $showObject);
    }

    public function getAllUdise(Request $request)
    {

        $udise = UdiseNodal::where('email', $this->state_nodal->user->email)
            ->where('district_id', $this->state_nodal->district->id)
            ->where('status', '<>', 'conflict')
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $udise);
    }

    public function getAllPendingUdise(Request $request)
    {

        $udise = UdiseNodal::where('email', $this->state_nodal->user->email)
            ->where('district_id', $this->state_nodal->district->id)
            ->where('status', 'conflict')
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $udise);
    }

    public function getApplicationCycleListing()
    {
        $applicationcycle = \Models\ApplicationCycle::select('session_year')
            ->distinct('session_year')
            ->orderBy('session_year', 'DESC')
            ->get();

        return api('', $applicationcycle);
    }

    public function getSchoolListing()
    {

        $nodal_id = $this->state_nodal->id;

        $nodal_schools = \Models\SchoolNodal::select('id', 'school_id')
            ->where('nodal_id', $nodal_id)->get();

        $nodal_school_ids = $nodal_schools->pluck('school_id')->all();

        $schools = \Models\School::select('id', 'name')
            ->whereIn('id', $nodal_school_ids)
            ->get();

        return api('', $schools);
    }

    public function getSchoolInfo($application_cycle_year, $district_id, $nodal_id, $refresh = 'false')
    {
        $district_id = $this->state_nodal->district_id;

        $nodal_id = $this->state_nodal->id;

        $state_id = $this->state->id;

        $cache_key = 'rte-nodal-getschoolinfo-api';

        if ($refresh == 'true') {

            Cache::store('file')->forget($cache_key);

            $data = \Helpers\DashboardHelper::getSchoolInfo($state_id, $application_cycle_year, $district_id, $nodal_id);

            // Cache Data
            $cache_data = [];
            $cache_data['data'] = $data;
            $cache_data['created_at'] = \Carbon::now();

            Cache::store('file')->rememberForever($cache_key, function () use ($cache_data) {

                return $cache_data;
            });

            $cache_data['created_at'] = \Carbon::parse($cache_data['created_at'])->diffForHumans();

            $data = $cache_data;

        } else {

            if (Cache::store('file')->has($cache_key)) {

                $cache_data = Cache::store('file')->get($cache_key);

                $cache_data['created_at'] = \Carbon::parse($cache_data['created_at'])->diffForHumans();
                $data = $cache_data;

            } else {

                $data = \Helpers\DashboardHelper::getSchoolInfo($state_id, $application_cycle_year, $district_id, $nodal_id);

                // Cache Data
                $cache_data = [];
                $cache_data['data'] = $data;
                $cache_data['created_at'] = \Carbon::now();

                Cache::store('file')->rememberForever($cache_key, function () use ($cache_data) {

                    return $cache_data;
                });

                $cache_data['created_at'] = \Carbon::parse($cache_data['created_at'])->diffForHumans();
                $data = $cache_data;
            }
        }

        return api('', $data);
    }

    public function applyFilterStudentDetails(Request $request, $refresh = 'false')
    {
        $request->merge([
            'selectedNodal' => $this->state_nodal->id,
        ]);

        $state_id = $this->state->id;

        $cache_key = 'rte-nodal-getstudentsinfo-api';

        if ($refresh == 'true') {

            Cache::store('file')->forget($cache_key);

            $data = \Helpers\DashboardStudentHelper::applyStudentFilter($state_id, $request);

            // Cache Data
            $cache_data = [];
            $cache_data['data'] = $data;
            $cache_data['created_at'] = \Carbon::now();

            Cache::store('file')->rememberForever($cache_key, function () use ($cache_data) {

                return $cache_data;
            });

            $cache_data['created_at'] = \Carbon::parse($cache_data['created_at'])->diffForHumans();
            $data = $cache_data;

        } else {

            if (Cache::store('file')->has($cache_key)) {

                $cache_data = Cache::store('file')->get($cache_key);

                $cache_data['created_at'] = \Carbon::parse($cache_data['created_at'])->diffForHumans();
                $data = $cache_data;

            } else {

                $data = \Helpers\DashboardStudentHelper::applyStudentFilter($state_id, $request);

                // Cache Data
                $cache_data = [];
                $cache_data['data'] = $data;
                $cache_data['created_at'] = \Carbon::now();

                Cache::store('file')->rememberForever($cache_key, function () use ($cache_data) {

                    return $cache_data;
                });

                $cache_data['created_at'] = \Carbon::parse($cache_data['created_at'])->diffForHumans();
                $data = $cache_data;
            }
        }

        return api('', $data);
    }

    public function applyFilterOverviewMetrics(Request $request)
    {

        $state_id = $this->state->id;

        $filtered_data = \Helpers\DashboardOverviewHelper::applyOveriewFilter($state_id, $request);

        $filtered_data['top_schools'] = \Helpers\DashboardOverviewHelper::getTopPerformingSchools($state_id, $request);

        return api('', $filtered_data);
    }

    public function getClassListing()
    {

        $class = \Models\Level::where('entry_point', true)
            ->get();

        return api('', $class);
    }
}
