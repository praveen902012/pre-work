<?php
namespace Redlof\RoleSchoolAdmin\Controllers\Role;

//use Redlof\Auth\Classes\AuthHelper;
use Helpers\SchoolDashboardHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Models\User;
use Redlof\Engine\Auth\Repositories\SchoolAdminRepo;
use Redlof\RoleSchoolAdmin\Controllers\Role\Requests\ChangePasswordRequest;
use Redlof\RoleSchoolAdmin\Controllers\Role\Requests\DashboardInfoRequest;
use Redlof\RoleSchoolAdmin\Controllers\Role\Requests\UpdatePhotoRequest;
use Redlof\RoleSchoolAdmin\Controllers\Role\Requests\UpdateProfileRequest;
use Redlof\RoleSchoolAdmin\Controllers\Role\RoleSchoolAdminBaseController;

class RoleSchoolAdminController extends RoleSchoolAdminBaseController
{

    public function __construct(SchoolAdminRepo $user)
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
            $Msg = 'Changed password successfully';
            $Status = Response::HTTP_OK;
        }

        $show['redirect'] = ['/schooladmin/profile'];

        return api($Msg, $show);
    }

    public function postUpdateProfile(UpdateProfileRequest $request)
    {

        $user = \AuthHelper::getCurrentUser();

        $Msg = 'Your profile details not updated successfully';
        $Status = Response::HTTP_UNPROCESSABLE_ENTITY;

        $user = User::where('id', $user->id)->update(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone' => $request->phone]);

        if ($user) {
            $Msg = 'Your profile details updated successfully';
            $Status = Response::HTTP_OK;
        }

        $reloadObj['reload'] = true;

        return api($Msg, $reloadObj);
    }

    public function postUpdatePhoto(UpdatePhotoRequest $request)
    {

        $user = \AuthHelper::getCurrentUser();

        $FileName = \ImageHelper::createFileName($request->photo);

        \ImageHelper::ImageUploadToS3($request->photo, $FileName, 'userphotos/', true, 100, 100);
        \UserHelper::updateFirstTimeUserPhoto($user->id, $FileName);

        $show['redirect'] = ['/schooladmin/profile'];

        return api('Photo updated successfully', $show);
    }

    public function getAdminInformation()
    {
        $User = $this->schooladmin;
        return response()->json(['data' => $User], 200);
    }

    public function getApplicationCycleListing()
    {

        $applicationcycle = \Models\ApplicationCycle::select('session_year')
            ->distinct('session_year')
            ->orderBy('session_year', 'DESC')
            ->get();

        return api('', $applicationcycle);

    }

    public function applySchoolFilter(Request $request)
    {

        $filteredData = SchoolDashboardHelper::getDashboardStatistics($this->school, $request);

        return api('', $filteredData);
    }

    public function editPreviousSchool(Request $request)
    {
        $application_cycle = \Helpers\ApplicationCycleHelper::getLatestCycle();

        $request->merge([
            'application_cycle_id' => $application_cycle->id,
        ]);

        $exist = \Models\SchoolCycle::where('application_cycle_id', $request->application_cycle_id)
            ->where('school_id', $request->school_id)
            ->first();

        if (empty($exist)) {

            $school = \Models\School::where('id', $request->school_id)->first();

            \Models\SchoolCycle::create([
                'school_id' => $school->id,
                'application_cycle_id' => $application_cycle->id,
                'status' => 'registered',
            ]);

            \Helpers\SchoolHelper::addSchoolLevels($school->id);

            $school->application_status = 'registered';

            $school->current_state = 'step1';

            $school->save();
        } else {

            $school = \Models\School::where('id', $request->school_id)->first();

            $school->application_status = 'registered';

            $school->current_state = 'step1';

            $school->save();
        }

        $data['redirect'] = route('schooladmin.edit-school');

        return api('', $data);
    }

    public function getClassLevels($entry_class_id, $highest_class_id)
    {
        $level_ids = \Models\Level::where('id', '>=', $entry_class_id)
            ->where('id', '<=', $highest_class_id)
            ->where('id', '<=', 18)
            ->pluck('id')
            ->toArray();

        return $level_ids;
    }

    public function getClassID($slug)
    {
        $classes = [];

        $classes['kg2'] = 3;
        $classes['class1'] = 4;
        $classes['class2'] = 12;
        $classes['class3'] = 13;
        $classes['class4'] = 14;
        $classes['class5'] = 15;
        $classes['class6'] = 16;
        $classes['class7'] = 17;
        $classes['class8'] = 18;
        $classes['class9'] = 18;
        $classes['class10'] = 18;
        $classes['class11'] = 18;
        $classes['class12'] = 18;

        return $classes[$slug];
    }

    public function getAdminDashboardInfo(DashboardInfoRequest $request)
    {

        $data = \AdminDashHelper::getDashboardData($request);

        $content['stats'] = \View::make('schooladmin::role.dashboard-data1')->with('data', $data)->render();
        $content['lists'] = \View::make('schooladmin::role.dashboard-data2')->with('data', $data)->render();

        return response()->json(['data' => $content, 'chartData' => $data], 200);
    }

    public function getAllUsers()
    {

    }
}
