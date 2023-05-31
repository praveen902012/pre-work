<?php
namespace Redlof\RoleNodalAdmin\Controllers\School;

use Carbon\Carbon;
use Exceptions\EntityNotFoundException;
use Illuminate\Http\Request;
use Models\School;
use Models\SchoolAdmin;
use Redlof\Engine\Auth\Repositories\SchoolAdminRepo;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleNodalAdmin\Controllers\Role\RoleNodalAdminBaseController;
use Redlof\RoleNodalAdmin\Controllers\School\Requests\AddSchoolAddressRequest;
use Redlof\RoleNodalAdmin\Controllers\School\Requests\AddSchoolBankDetailsRequest;
use Redlof\RoleNodalAdmin\Controllers\School\Requests\AddSchoolDetailsRequest;
use Redlof\RoleNodalAdmin\Controllers\School\Requests\AddSchoolNeighbourhoodRequest;
use Redlof\RoleNodalAdmin\Controllers\School\Requests\AddSchoolRequest;
use Redlof\RoleNodalAdmin\Controllers\School\Requests\RecheckRequest;
use Redlof\RoleNodalAdmin\Controllers\School\Requests\RejectRequest;
use Redlof\RoleNodalAdmin\Controllers\School\Requests\UpdateSchoolRequest;

class SchoolController extends RoleNodalAdminBaseController
{

    public function __construct()
    {

        parent::__construct();
    }

    public function getAllSchool(Request $request)
    {

        $schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->with('school')
            ->get();

        return api('', $schools);
    }

    public function getSchoolsAllList(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->with('school')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getSchoolsAll(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) {
                $subQuery = $subQuery->where('application_status', 'registered')
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getDownloadSchoolsAll(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $all_schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) {
                $subQuery = $subQuery->where('application_status', 'registered')
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school', 'school.school_ranges', 'school.locality', 'school.block', 'school.district', 'school.state', 'school.language')
            ->get();

        $items = $this->getDownloadCsvData($all_schools, $request);

        $reports = \Excel::create('registered-schools-list', function ($excel) use ($items) {

            $excel->sheet('Registered Schools List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'registered-schools-list.xlsx', 'data' => asset('temp/registered-schools-list.xlsx')], 200);

    }

    public function getDownloadSchoolsAllList(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $all_schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->with('school', 'school.school_ranges', 'school.locality', 'school.block', 'school.district', 'school.state', 'school.language')
            ->get();

        $items = $this->getDownloadCsvData($all_schools, $request);

        $reports = \Excel::create('all-schools-list', function ($excel) use ($items) {

            $excel->sheet('All Schools List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'all-schools-list.xlsx', 'data' => asset('temp/all-schools-list.xlsx')], 200);

    }

    public function getSchoolDetails($school_id)
    {

        $school = School::find($school_id);

        return api('', $school);
    }

    public function getRegisteredSchools(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) {
                $subQuery = $subQuery->where('application_status', 'registered')
                    ->where('status', 'active')
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school')
            ->page($request)
            ->get()
            ->map(function ($item) use ($request) {

                $item->session_year = (!empty($request->selectedCycle)) ? $request->selectedCycle : $this->data['latest_application_cycle']['session_year'];

                return $item;
            })
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getVerifiedSchools(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) {
                $subQuery = $subQuery->where('application_status', 'verified')
                    ->where('status', 'active')
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school')
            ->page($request)
            ->get()
            ->map(function ($item) use ($request) {

                $item->session_year = (!empty($request->selectedCycle) || $request->selectedCycle != 'null') ? $request->selectedCycle : $this->data['latest_application_cycle']['session_year'];

                return $item;
            })
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getDownloadRegisteredSchools(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $all_schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) {
                $subQuery = $subQuery->where('application_status', 'verified')
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school', 'school.school_ranges', 'school.locality', 'school.block', 'school.district', 'school.state', 'school.language')
            ->get();

        $items = $this->getDownloadCsvData($all_schools, $request);

        $reports = \Excel::create('verified-schools-list', function ($excel) use ($items) {

            $excel->sheet('Verified Schools List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'verified-schools-list.xlsx', 'data' => asset('temp/verified-schools-list.xlsx')], 200);
    }

    public function getRejectedSchools(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) {
                $subQuery = $subQuery->where('application_status', 'rejected')
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school')
            ->page($request)
            ->get()
            ->map(function ($item) use ($request) {

                $item->session_year = (!empty($request->selectedCycle) || $request->selectedCycle != 'null') ? $request->selectedCycle : $this->data['latest_application_cycle']['session_year'];

                return $item;
            })
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getDownloadRejectedSchools(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $all_schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) {
                $subQuery = $subQuery->where('application_status', 'rejected')
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school', 'school.school_ranges', 'school.locality', 'school.block', 'school.district', 'school.state', 'school.language')
            ->get();

        $items = $this->getDownloadCsvData($all_schools, $request);

        $reports = \Excel::create('rejected-schools-list', function ($excel) use ($items) {

            $excel->sheet('Rejected Schools List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'rejected-schools-list.xlsx', 'data' => asset('temp/rejected-schools-list.xlsx')], 200);
    }

    public function getBannedSchools(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) {
                $subQuery = $subQuery->where('status', 'ban')
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school')
            ->page($request)
            ->get()
            ->map(function ($item) use ($request) {

                $item->session_year = (!empty($request->selectedCycle) || $request->selectedCycle != 'null') ? $request->selectedCycle : $this->data['latest_application_cycle']['session_year'];

                return $item;
            })
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getDownloadBannedSchools(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $all_schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) {
                $subQuery = $subQuery->where('status', 'ban')
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school', 'school.school_ranges', 'school.locality', 'school.block', 'school.district', 'school.state', 'school.language')
            ->get();

        $items = $this->getDownloadCsvData($all_schools, $request);

        $reports = \Excel::create('banned-schools-list', function ($excel) use ($items) {

            $excel->sheet('Banned Schools List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'banned-schools-list.xlsx', 'data' => asset('temp/banned-schools-list.xlsx')], 200);
    }

    public function getSearchSchools(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) use ($request) {
                $subQuery = $subQuery->where('application_status', 'registered')
                    ->where(function ($query) use ($request) {
                        $query->where('name', 'ilike', '%' . $request['s'] . '%')
                            ->orWhere('udise', $request['s']);
                    })
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school')
            ->page($request)
            ->get()
            ->map(function ($item) use ($request) {

                $item->session_year = (!empty($request->selectedCycle) || $request->selectedCycle != 'null') ? $request->selectedCycle : $this->data['latest_application_cycle']['session_year'];

                return $item;
            })
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getSearchSchoolslist(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('udise', $request['s']);
            })
            ->with('school')
            ->page($request)
            ->get()
            ->map(function ($item) use ($request) {

                $item->session_year = (!empty($request->selectedCycle) || $request->selectedCycle != 'null') ? $request->selectedCycle : $this->data['latest_application_cycle']['session_year'];

                return $item;
            })
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getSearchRegisteredSchools(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) use ($request) {
                $subQuery = $subQuery->where('application_status', 'verified')
                    ->where('status', 'active')
                    ->where(function ($query) use ($request) {
                        $query->where('name', 'ilike', '%' . $request['s'] . '%')
                            ->orWhere('udise', $request['s']);
                    })
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school')
            ->page($request)
            ->get()
            ->map(function ($item) use ($request) {

                $item->session_year = (!empty($request->selectedCycle) || $request->selectedCycle != 'null') ? $request->selectedCycle : $this->data['latest_application_cycle']['session_year'];

                return $item;
            })
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getSearchRejectedSchools(Request $request)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) use ($request) {
                $subQuery = $subQuery->where('application_status', 'rejected')
                    ->where(function ($query) use ($request) {
                        $query->where('name', 'ilike', '%' . $request['s'] . '%')
                            ->orWhere('udise', $request['s']);
                    })
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school')
            ->page($request)
            ->get()
            ->map(function ($item) use ($request) {

                $item->session_year = (!empty($request->selectedCycle) || $request->selectedCycle != 'null') ? $request->selectedCycle : $this->data['latest_application_cycle']['session_year'];

                return $item;
            })
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getSearchBannedSchools(Request $request)
    {

        $selected_year = $this->data['latest_application_cycle']->session_year;

        if (!empty($request->selectedCycle)) {

            $selected_year = $request->selectedCycle;
        }

        $schoolIds = \Models\SchoolCycle::whereHas('application_cycle', function ($query) use ($selected_year) {

            $query->where('session_year', $selected_year);

        })->pluck('school_id');

        $schools = \Models\SchoolNodal::where('nodal_id', $this->state_nodal->id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('school', function ($subQuery) use ($request) {
                $subQuery = $subQuery->where('status', 'ban')
                    ->where(function ($query) use ($request) {
                        $query->where('name', 'ilike', '%' . $request['s'] . '%')
                            ->orWhere('udise', $request['s']);
                    })
                    ->from(with(new \Models\School)->getTable());
            })
            ->with('school')
            ->page($request)
            ->get()
            ->map(function ($item) use ($request) {

                $item->session_year = (!empty($request->selectedCycle) || $request->selectedCycle != 'null') ? $request->selectedCycle : $this->data['latest_application_cycle']['session_year'];

                return $item;
            })
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function postSchoolAdd(AddSchoolRequest $request, SchoolAdminRepo $schoolRepo)
    {

        if ($request->eshtablished > \Carbon::now()->year) {
            throw new ValidationFailedException("Established year should be less than the current year");
        }

        if ($request->hasFile('image')) {

            $file_name = \ImageHelper::createFileName($request['image']);

            \ImageHelper::ImageUploadToS3($request['image'], $file_name, 'school/', true, 1200, 600, true);
            $request->merge(['logo' => $file_name]);
        }

        $request->merge(['language_id' => $request->medium['id']]);

        $newSchool = School::create($request->all());

        \Helpers\SchoolHelper::addSchoolLevels($newSchool->id);

        $newSchoolAdmin = new \Models\SchoolAdmin();

        $newSchoolAdmin->school_id = $newSchool->id;
        $input['first_name'] = $request['name'];
        $input['last_name'] = $request['name'];
        $input['email'] = $request['admin_email'];
        $input['phone'] = $request['admin_phone'];
        $input['role_type'] = 'role-school-admin';
        $input['password'] = str_random(8);

        $user = $schoolRepo->create($input);

        $newSchoolAdmin->user_id = $user['id'];
        $newSchoolAdmin->save();

        $data['redirect'] = route('nodaladmin.edit-school-address', [$request->udise]);

        return api('Primary details has been saved successfully', $data);
    }

    public function addSchoolAddress(AddSchoolAddressRequest $request, $state, $udise, UserRepo $userRepo)
    {

        $school = School::where('udise', $udise)
            ->update([
                'state_id' => $request['state']['id'],
                'district_id' => $request['district_id'],
                'block_id' => $request['block_id'],
                'locality_id' => $request['locality_id'],
            ]);

        $data['redirect'] = route('school.add-school-region', [$request->udise]);

        return api('Address details has been saved successfully', $data);

    }

    public function postSchoolUpdate(AddSchoolRequest $request)
    {

        $newSchool = School::where('id', $request->id)->update(['name' => $request->name]);

        return api('School updated', $newSchool);
    }

    public function postAddSchoolAdmin(AddSchoolRequest $request, UserRepo $userRepo)
    {

        $newSchoolAdmin = new SchoolAdmin();

        $newSchoolAdmin->school_id = $request->school_id;
        $request['role_type'] = 'role-school-admin';
        $request['password'] = 'think201today';

        $user = $userRepo->create($request);

        $newSchoolAdmin->user_id = $user['id'];
        $newSchoolAdmin->save();

        return api('Created School Admin', $user);
    }

    public function postAcceptSchool(Request $request, $school_id)
    {

        $school = School::find($school_id);

        // if (Carbon::parse($this->data['latest_application_cycle']['created_at']) > Carbon::parse($school->created_at)) {

        //     throw new EntityNotFoundException("Cannot accept previous cycle school");
        // }

        $school->application_status = 'verified';

        $school->accept_reason = $request['accept_reason'];

        $school->save();

        $reimbursement = new \Models\SchoolReimbursement();

        $reimbursement['school_id'] = $school_id;

        $reimbursement['reimbursement_amount'] = 0;

        $reimbursement->save();

        // Update the application status for the cycle

        \Models\SchoolCycle::where('school_id', $school->id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']['id'])
            ->update(['status' => 'verified']);

        $showObject = ['reload' => true];

        return api('school verified', $showObject);
    }

    public function postRejectSchool(RejectRequest $request, $school_id)
    {

        $school = School::find($school_id);

        // if (Carbon::parse($this->data['latest_application_cycle']['created_at']) > Carbon::parse($school->created_at)) {

        //     throw new EntityNotFoundException("Cannot reject previous cycle school");
        // }

        $school->application_status = 'rejected';

        $school->reject_reason = $request['reject_reason'];

        $school->save();

        // Update the school cycle status
        \Models\SchoolCycle::where('school_id', $school->id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']['id'])
            ->update(['status' => 'rejected']);

        $showObject = ['reload' => true];

        return api('School rejected', $showObject);
    }

    public function postRecheckSchool(RecheckRequest $request, $school_id)
    {

        $school = School::where('id', $school_id)->with('schooladmin', 'schooladmin.user')->first();

        // if (Carbon::parse($this->data['latest_application_cycle']['created_at']) > Carbon::parse($school->created_at)) {

        //     throw new EntityNotFoundException("Cannot recheck previous cycle school");
        // }

        $school->application_status = 'recheck';

        $school->recheck_reason = $request['recheck_reason'];

        $school->save();

        $input['phone'] = $school->schooladmin->user->phone;
        $input['message'] = 'Nodal admin has requested you to recheck your school details, Please login to your dashboard to edit the details.';

        \MsgHelper::sendSyncSMS($input);

        \Models\SchoolCycle::where('school_id', $school->id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']['id'])
            ->update(['status' => 'recheck']);

        $showObject = ['reload' => true];

        return api('School has been sent for recheck', $showObject);
    }

    public function postBanSchool($school_id)
    {

        $school = School::find($school_id);

        // if (Carbon::parse($this->data['latest_application_cycle']['created_at']) > Carbon::parse($school->created_at)) {

        //     throw new EntityNotFoundException("Cannot ban previous cycle school");
        // }

        $school->status = 'ban';
        $school->save();

        $showObject = [
            'reload' => true,
        ];

        return api('school banned', $showObject);
    }

    public function postUnVerifySchool($school_id)
    {

        $school = School::find($school_id);

        // if (Carbon::parse($this->data['latest_application_cycle']['created_at']) > Carbon::parse($school->created_at)) {

        //     throw new EntityNotFoundException("Cannot unverify previous cycle school");
        // }

        $school->application_status = 'registered';
        $school->save();

        $showObject = ['reload' => true];

        // Update the school cycle status

        \Models\SchoolCycle::where('school_id', $school->id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']['id'])
            ->update(['status' => 'registered']);

        return api('school Un-verified', $showObject);
    }

    public function postUnBanSchool($school_id)
    {

        $school = School::find($school_id);

        if (Carbon::parse($this->data['latest_application_cycle']['created_at']) > Carbon::parse($school->created_at)) {

            throw new EntityNotFoundException("Cannot Unban previous cycle school");
        }

        $school->status = 'active';
        $school->save();

        $showObject = ['reload' => true];

        return api('school activated', $showObject);
    }

    public function getSchoolEditDetails($school_id)
    {

        $school = \Models\School::select('id', 'name', 'udise', 'logo', 'language_id', 'phone', 'website', 'levels', 'type', 'description', 'school_type', 'rte_certificate_no')
            ->where('id', $school_id)
            ->with(['schooladmin', 'schooladmin.user', 'language'])
            ->first();

        $level = '';

        foreach ($school['levels'] as $key => $l) {
            $value = $l;

            $level = $value;

        }

        $school['level'] = $level;

        return api('', $school);
    }

    public function getSchoolAddressDetails($school_id)
    {

        $school = \Models\School::select('id', 'address', 'state_id', 'district_id', 'locality_id', 'sub_locality_id', 'sub_sub_locality_id', 'block_id', 'lat', 'lng', 'pincode', 'state_type', 'sub_block_id', 'cluster_id')
            ->with(['state', 'district', 'block', 'locality', 'sublocality', 'subsublocality', 'cluster'])
            ->where('id', $school_id)
            ->first();

        if (!empty($school->state)) {
            $school->state_name = $school->state->name;
        }

        if (!empty($school->district)) {
            $school->district_name = $school->district->name;
        }

        if (!empty($school->block)) {

            $school->block_name = $school->block->name;
            $school->block_type = $school->block->type;

        }
        if (!empty($school->sub_block_id)) {
            $subname = \Models\Block::select('name')->where('id', $school->sub_block_id)->first();
            $school->sub_block_name = $subname->name;
        }

        if (!empty($school->locality)) {
            $school->locality_name = $school->locality->name;
        }

        if (!empty($school->sublocality)) {
            $school->sub_locality_name = $school->sublocality->name;
        }

        if (!empty($school->subsublocality)) {
            $school->sub_sub_locality_name = $school->subsublocality->name;
        }

        $school = collect($school)->except(['district', 'block', 'locality', 'sublocality', 'subsublocality'])->all();

        return api('', $school);
    }

    public function getSchoolRegionDetails($school_id)
    {

        $school = \Models\School::where('id', $school_id)
            ->select('id', 'sub_block_id', 'locality_id', 'district_id')
            ->first();

        $regions = \Models\SchoolRange::where('school_id', $school_id)
            ->where('range', '1-3')
            ->select('id', 'regions')
            ->first();

        $selected_region = [];

        if (count($regions) > 0) {
            $selected_region = $regions['regions'];
        }

        $subLocalities = \Models\Locality::select('id', 'name')
        /*->whereHas('block.district', function ($subQuery) use ($school) {
        $subQuery = $subQuery->where('id', $school->district_id);
         */
            ->where('block_id', $school->sub_block_id)
            ->whereNotIn('id', [$school->locality_id])
            ->whereNotIn('id', $selected_region);

        $Localities['unselected'] = $subLocalities->get();

        $subLocalities = \Models\Locality::select('id', 'name')
            ->whereHas('block.district', function ($subQuery) use ($school) {
                $subQuery = $subQuery->where('id', $school->district_id);
            })
            ->where('block_id', '!=', $school->sub_block_id)
            ->whereNotIn('id', [$school->locality_id])
            ->whereNotIn('id', $selected_region);

        $Localities['unselectedDist'] = $subLocalities->get();

        $subLocalities = \Models\Locality::select('id', 'name')
        /*->whereHas('block.district', function ($subQuery) use ($school) {
        $subQuery = $subQuery->where('id', $school->district_id);
         */
            ->where('block_id', $school->sub_block_id)
            ->whereNotIn('id', [$school->locality_id])
            ->whereIn('id', $selected_region);

        $Localities['selected'] = $subLocalities->get();

        $subLocalities = \Models\Locality::select('id', 'name')
            ->whereHas('block.district', function ($subQuery) use ($school) {
                $subQuery = $subQuery->where('id', $school->district_id);
            })
            ->where('block_id', '!=', $school->sub_block_id)
            ->whereNotIn('id', [$school->locality_id])
            ->whereIn('id', $selected_region);

        $Localities['selectedDist'] = $subLocalities->get();

        return api('', $Localities);
    }

    public function postUpdatePrimaryDetials($school_id, UpdateSchoolRequest $request, SchoolAdminRepo $schoolRepo)
    {

        if ($request->eshtablished > \Carbon::now()->year) {
            throw new ValidationFailedException("Established year should be less than the current year");
        }

        if ($request->hasFile('photo')) {

            $file_name = \ImageHelper::createFileName($request['photo']);

            \ImageHelper::ImageUploadToS3($request['photo'], $file_name, 'school/', true, 1200, 600, true);
            $request->merge(['logo' => $file_name]);
        }

        $request->merge(['language_id' => $request->medium['id']]);

        $previousData = School::find($school_id);

        $newSchool = School::find($school_id);

        $newSchool['name'] = $request['name'];
        $new_level[] = $request['level'];
        $newSchool['levels'] = $new_level;

        $newSchool['udise'] = $request['udise'];

        $newSchool['logo'] = $request['logo'];

        $newSchool['language_id'] = $request['language_id'];

        $newSchool['type'] = $request['type'];

        $newSchool['rte_certificate_no'] = $request['rte_certificate_no'];

        $newSchool['school_type'] = $request['school_type'];

        $newSchool['phone'] = $request['phone'];

        $newSchool->save();

        if ($previousData->type != $request['type'] || !in_array($request['level'], $previousData->levels)) {

            \Helpers\SchoolHelper::updateSchoolLevels($previousData->id, $request);
        }

        if (isset($request['website'])) {

            $upSchool = School::where('id', $school_id)
                ->update([

                    'website' => $request['website'],

                ]);
        }

        if (isset($request['description'])) {

            $upSchool = School::where('id', $school_id)
                ->update([

                    'description' => $request['description'],

                ]);
        }

        $newSchoolAdmin = \Models\User::find($request->schooladmin['user_id']);

        if ($request['admin_email']) {

            $newSchoolAdmin['email'] = $request['admin_email'];

        }

        $newSchoolAdmin['phone'] = $request['admin_phone'];

        $newSchoolAdmin->save();

        $data['redirect'] = route('nodaladmin.edit-school-address', $request->udise);

        return api('Primary details has been updated successfully', $data);
    }

    public function postUpdateAddressDetials(AddSchoolAddressRequest $request, $udise)
    {

        $school = School::where('udise', $udise)
            ->update([
                'state_id' => $request['state']['id'],
                'district_id' => $request['district_id'],
                'block_id' => $request['block_id'],
                'sub_block_id' => $request['sub_block_id'],
                'state_type' => $request['state_type'],
                'locality_id' => $request['locality_id'],
                // 'cluster_id' => $request['cluster_id'],
                'address' => $request['address'],
                'pincode' => $request['pincode'],
                'lat' => $request['lat'],
                'lng' => $request['lng'],
            ]);

        $data['redirect'] = route('nodaladmin.update-region', $udise);

        return api('Address details has been saved successfully', $data);

    }

    public function postUpdateRegionDetials(AddSchoolNeighbourhoodRequest $request, $udise)
    {

        $school = School::where('udise', $udise)->select('id', 'district_id', 'locality_id')->first();

        $newSchoolRange = \Models\SchoolRange::updateOrCreate(

            [
                'school_id' => $school->id,
                'range' => '0-1',
                'type' => 'district',
            ],
            [
                'regions' => [(string) $school->locality_id],
            ]

        );

        $newSchoolRange = \Models\SchoolRange::updateOrCreate(

            [
                'school_id' => $school->id,
                'range' => '1-3',
                'type' => 'district',
            ],
            [
                'regions' => $request->range0,
            ]

        );

        $data['redirect'] = route('nodaladmin.update-fee', $udise);

        return api('Neighbourhood areas of the school have been saved successfully', $data);

    }

    public function getSchoolFeeDetails($id)
    {

        $school = School::where('id', $id)->select('id', 'levels', 'type')->first();

        $existing_fee_details = \Models\SchoolLevelInfo::where('school_id', $school->id)
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->with(['level_info'])
            ->orderBy('level_id', 'asc')
            ->get();

        return api('', $existing_fee_details);
    }

    public function getSchoolSeatDetails($udise)
    {

        $school = School::where('udise', $udise)->select('id', 'levels')->first();

        $levels = \Models\Level::select('id', 'level')->whereIn('id', $school['levels'])->get();

        $stats = \Models\AllottmentStatistic::where('school_id', $school->id)
            ->select('year', 'allotted_seats', 'dropouts', 'level_id')
            ->get();

        $school_levels = \Models\SchoolLevelInfo::where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->where('school_id', $school->id)
            ->select('level_id', 'available_seats', 'total_seats')
            ->whereIn('level_id', $school['levels'])
            ->get();

        $legacyData = [];

        foreach ($school['levels'] as $key => $level_id) {

            $legacy = [];
            $legacy['level'] = $levels->where('id', $level_id)->pluck('level')->first();

            if ($legacy['level'] == 'Pre-Primary') {
                $legacy['dropouts_2017'] = 0;
            }

            $legacy['alloted_seats_2015'] = 0;
            $legacy['alloted_seats_2016'] = 0;
            $legacy['alloted_seats_2017'] = 0;
            $legacy['alloted_seats_2018'] = 0;
            $legacy['available_seats'] = 0;
            $legacy['total_seats'] = 0;

            if (count($stats) > 0) {

                $yearly_stats = $stats->where('level_id', intval($level_id))->all();

                if (count($yearly_stats) > 0) {

                    foreach ($yearly_stats as $key => $yearly_stats) {

                        $legacy['alloted_seats_' . $yearly_stats['year']] = $yearly_stats['allotted_seats'];

                        if ($yearly_stats['year'] == 2017 && $legacy['level'] == 'Pre-Primary') {

                            $legacy['dropouts_2017'] = $yearly_stats['dropouts'];
                        }
                    }

                }

            }

            if (count($school_levels) > 0) {

                $legacy['available_seats'] = $school_levels->where('level_id', $level_id)
                    ->pluck('available_seats')->first();

                $legacy['total_seats'] = $school_levels->where('level_id', $level_id)
                    ->pluck('total_seats')->first();
            }

            array_push($legacyData, $legacy);
        }

        return api('', $legacyData);
    }

    public function getPastSeatDetails($udise)
    {

        $school = School::where('udise', $udise)->select('id', 'levels')->first();

        $levels = \Models\Level::select('id', 'level')->whereIn('id', $school['levels'])->get();

        $seat_info = \Models\SchoolSeatInfo::where('school_id', $school->id)
            ->where('level_id', $levels[0]->id)
            ->orderBy('year', 'desc')
            ->limit(3)
            ->get();

        $levels = \Models\Level::select('id', 'level')->whereIn('id', $school['levels'])->get();

        if ($seat_info->count() == 0) {

            $pastInfo = (object) [];
            $pastInfo->level = $levels[0]->level;
            $pastInfo->first_year = 0;
            $pastInfo->second_year = 0;
            $pastInfo->third_year = 0;

        } else {

            $pastInfo = (object) [];
            $pastInfo->level = $levels[0]->level;
            $pastInfo->first_year = 0;
            $pastInfo->second_year = 0;
            $pastInfo->third_year = 0;

            if (isset($seat_info[0])) {
                $pastInfo->first_year = (int) $seat_info[0]->total_seats;
            }
            if (isset($seat_info[1])) {
                $pastInfo->second_year = (int) $seat_info[1]->total_seats;
            }
            if (isset($seat_info[2])) {
                $pastInfo->third_year = (int) $seat_info[2]->total_seats;
            }

        }

        return api('', $pastInfo);
    }

    public function postUpdateSeatDetials($udise, AddSchoolDetailsRequest $request)
    {

        $school = School::where('udise', $udise)->select('id', 'levels', 'cycle')->first();

        $levels = \Models\Level::select('id', 'level')->whereIn('id', collect($request['feestructure'])->pluck('level_id')->all())->get();

        \Helpers\SchoolHelper::updateSchoolLevelSeats($school->id, $request);

        \Models\AllottmentStatistic::where('school_id', $school->id)->delete();

        foreach ($request['seatinfo'] as $key => $value) {

            $level_id = $levels->where('level', $value['level'])
                ->pluck('id')
                ->first();

            foreach ($value as $key1 => $year_stat) {

                if (in_array($key1, ['alloted_seats_2015', 'alloted_seats_2016', 'alloted_seats_2017'])) {

                    $parts = explode("_", $key1);

                    if (count($parts) > 2 && $parts[0] == 'alloted') {
                        $year = $parts[2];

                        if (in_array($year, ['2015', '2016', '2017'])) {

                            $allottmentStats = new \Models\AllottmentStatistic();

                            if ($year == '2017' && isset($value['dropouts_2017'])) {

                                $allottmentStats->dropouts = $value['dropouts_2017'];
                            }

                            $allottmentStats->year = $year;
                            $allottmentStats->allotted_seats = $value['alloted_seats_' . $year];
                            $allottmentStats->level_id = $level_id;
                            $allottmentStats->school_id = $school->id;

                            $allottmentStats->save();

                        }
                    }

                }

            }

        }

        //New Way to Store Past Allotment Statistics in better way.

        $seat_info = \Models\SchoolSeatInfo::where('school_id', $school->id)
            ->orderBy('year', 'desc')
            ->limit(3)
            ->get();

        $levels = \Models\Level::select('id', 'level')->whereIn('id', $school['levels'])->get();

        $year = $this->data['latest_application_cycle']['session_year'];

        if ($seat_info->count() == 0) {

            //Create new entries

            for ($i = 1; $i <= 3; $i++) {

                $pastInfo = [
                    'school_id' => $school->id,
                    'level_id' => $levels[0]->id,
                    'year' => $year - 3 + $i,

                ];

                if ($i == 1) {
                    $pastInfo['total_seats'] = $request->past_seat_info['third_year'];
                } elseif ($i == 2) {
                    $pastInfo['total_seats'] = $request->past_seat_info['second_year'];
                } else {
                    $pastInfo['total_seats'] = $request->past_seat_info['first_year'];
                }

                \Models\SchoolSeatInfo::create($pastInfo);
            }

        } else {

            //Update excisting entries

            for ($i = 1; $i <= 3; $i++) {

                $cycleYear = $year - 3 + $i;

                $pastInfo = \Models\SchoolSeatInfo::where('year', $cycleYear)
                    ->where('school_id', $school->id)
                    ->where('level_id', $levels[0]->id)
                    ->first();

                if (!empty($pastInfo)) {

                    if ($i == 1) {
                        $pastInfo['total_seats'] = $request->past_seat_info['third_year'];
                    } elseif ($i == 2) {
                        $pastInfo['total_seats'] = $request->past_seat_info['second_year'];
                    } else {
                        $pastInfo['total_seats'] = $request->past_seat_info['first_year'];
                    }

                    $pastInfo->save();

                } else {

                    $pastInfo = [
                        'school_id' => $school->id,
                        'level_id' => $levels[0]->id,
                        'year' => $cycleYear,

                    ];

                    if ($i == 1) {
                        $pastInfo['total_seats'] = $request->past_seat_info['third_year'];
                    } elseif ($i == 2) {
                        $pastInfo['total_seats'] = $request->past_seat_info['second_year'];
                    } else {
                        $pastInfo['total_seats'] = $request->past_seat_info['first_year'];
                    }

                    \Models\SchoolSeatInfo::create($pastInfo);
                }

            }

        }

        $data['redirect'] = route('nodaladmin.update-bank', $udise);

        return api('School fee & seat info have been saved successfully', $data);

    }

    public function getSchoolBankDetails($school_id)
    {

        $bank = \Models\SchoolBankDetails::where('school_id', $school_id)->first();

        if (!isset($bank->ifsc_code)) {
            $bank = collect($bank)->except(['ifsc_code']);
        }

        return api('', $bank);
    }

    public function postUpdateBankDetials($udise, AddSchoolBankDetailsRequest $request)
    {

        $school = School::where('udise', $udise)->select('id', 'district_id', 'locality_id', 'udise', 'application_status')->with(['schooladmin', 'schooladmin.user'])->first();

        $schoolBank = \Models\SchoolBankDetails::updateOrCreate(
            ['school_id' => $school->id],
            [
                'account_number' => $request['account_number'],
                'account_holder_name' => $request['account_holder_name'],
                'bank_name' => $request['bank_name'],
                'branch' => $request['branch'],
            ]);

        $schoolBank = \Models\SchoolBankDetails::where('school_id', $school->id)
            ->first();

        if (!isset($request['ifsc_code']) || empty($request['ifsc_code'])) {
            $schoolBank->ifsc_code = null;
        } else {
            $schoolBank->ifsc_code = $request['ifsc_code'];
        }

        $schoolBank->save();

        if ($school->application_status == 'applied') {

            $newPass = str_random(8);
            $hashPasword = bcrypt($newPass);

            $newSchoolAdmin = \Models\User::where('id', $school->schooladmin->user->id)
                ->update(['password' => $hashPasword]);

            if (filter_var($school->schooladmin->user->email, FILTER_VALIDATE_EMAIL)) {

                if (!empty($school->schooladmin->user->email)) {

                    $EmailData = array(
                        'first_name' => $school->schooladmin->user->first_name,
                        'email' => $school->schooladmin->user->email,
                        'phone' => $school->schooladmin->user->phone,
                        'password' => $newPass,
                    );

                    $subject = 'RTE Credentials!';

                    \MailHelper::sendSyncMail('state::emails.school-registration-successful', $subject, $school->schooladmin->user->email, $EmailData);

                    $subject2 = 'Welcome to RTE!';

                    \MailHelper::sendSyncMail('admin::emails.welcome-schooladmin', $subject2, $school->schooladmin->user->email, $EmailData);

                }

            }

            $input['phone'] = $school->schooladmin->user->phone;
            $input['message'] = 'Registration completed successfully. Use your mobile number as username and following password to login ' . $newPass;

            \MsgHelper::sendSyncSMS($input);

            $checkUdise = \Models\UdiseNodal::where('udise', $school->udise)
                ->first();

            if (count($checkUdise) > 0) {

                if ($checkUdise->status != 'conflict') {

                    $nodalUser = \Models\User::select('id')
                        ->where('email', $checkUdise->email)
                        ->first();

                    if (count($nodalUser) > 0) {

                        $nodalAdmin = \Models\StateNodal::select('id')
                            ->where('user_id', $nodalUser->id)
                            ->first();

                        if (count($nodalAdmin) > 0) {

                            if ($nodalAdmin->id == $this->state_nodal->id) {

                                \Models\School::where('udise', $udise)
                                    ->update(['application_status' => 'verified']);

                                $alreadyassigned = \Models\SchoolNodal::where('school_id', $school->id)->first();

                                if (empty($alreadyassigned)) {

                                    $newSchoolDetails = new \Models\SchoolNodal();

                                    $newSchoolDetails['school_id'] = $school->id;

                                    $newSchoolDetails['nodal_id'] = $this->state_nodal->id;

                                    $newSchoolDetails->save();
                                }

                                $reimbursement = new \Models\SchoolReimbursement();

                                $reimbursement['school_id'] = $school->id;

                                $reimbursement['reimbursement_amount'] = 0;

                                $reimbursement->save();

                            } else {
                                \Models\School::where('udise', $udise)
                                    ->update(['application_status' => 'registered']);
                            }

                        } else {
                            \Models\School::where('udise', $udise)
                                ->update(['application_status' => 'registered']);
                        }

                    } else {
                        \Models\School::where('udise', $udise)
                            ->update(['application_status' => 'registered']);
                    }
                }

            } else {

                \Models\School::where('udise', $udise)
                    ->update(['application_status' => 'verified']);

                $alreadyassigned = \Models\SchoolNodal::where('school_id', $school->id)->first();

                if (empty($alreadyassigned)) {

                    $newSchoolDetails = new \Models\SchoolNodal();

                    $newSchoolDetails['school_id'] = $school->id;

                    $newSchoolDetails['nodal_id'] = $this->state_nodal->id;

                    $newSchoolDetails->save();
                }

                $reimbursement = new \Models\SchoolReimbursement();

                $reimbursement['school_id'] = $school->id;

                $reimbursement['reimbursement_amount'] = 0;

                $reimbursement->save();

            }

            $school = School::where('udise', $udise)->update(['current_state' => 'step5']);

        }

        // Update the school cycle status
        $schoolData = School::where('udise', $udise)->first();

        \Models\SchoolCycle::where('school_id', $schoolData->id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']['id'])
            ->update(['status' => $schoolData->application_status]);

        $data['redirect'] = route('school.registered-schools');

        return api('School registration details has been updated', $data);
    }

    public function deleteSchoolsRepeated()
    {

        $adminSchools = \Models\SchoolAdmin::pluck('school_id');

        $deleteSchool = \Models\School::whereNotIn('id', $adminSchools)->delete();

        $schools = \Models\SchoolNodal::all();

        $schoolsUnique = $schools->unique('school_id');

        $schoolsDupes = $schools->diff($schoolsUnique);

        $ids_to_be_deleted = $schoolsDupes->pluck('id')->toArray();

        \Models\SchoolNodal::whereIn('id', $ids_to_be_deleted)->forceDelete();

        http_response_code(500);
        dd('deleted');

    }

    private function getDownloadCsvData($all_schools, $request)
    {

        $current_year = $this->data['latest_application_cycle']['session_year'];

        if (!empty($request->selectedCycle) && $request->selectedCycle != 'null') {

            $current_year = $request->selectedCycle;
        }

        $items = [];

        if (count($all_schools) != 0) {

            foreach ($all_schools as $result) {

                $result = $result->toArray();

                $InnData['Registered School Name'] = $result['school']['name'];
                $InnData['UDISE Code'] = $result['school']['udise'];

                $InnData['Entry Class'] = '';

                $entry_class = \Models\Level::where('id', $result['school']['levels'][0])
                    ->first();

                if ($entry_class) {
                    $InnData['Entry Class'] = $entry_class->level;
                }

                $InnData['Total seats in the entry level class'] = 0;
                $InnData['Total seats under 25% quota'] = 0;

                $seat = \Models\SchoolLevelInfo::where('school_id', $result['school']['id'])
                    ->where('level_id', $result['school']['levels'][0])
                    ->where('session_year', $current_year)
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($seat) {
                    $InnData['Total seats in the entry level class'] = $seat->total_seats;
                    $InnData['Total seats under 25% quota'] = $seat->available_seats;
                }

                $InnData['Total registrations'] = 0;
                $InnData['Total verification'] = 0;
                $InnData['Total allotment'] = 0;
                $InnData['Total admissions'] = 0;
                $InnData['School address'] = $result['school']['address'];
                $InnData['Ward/ Gram panchayat'] = $result['school']['locality']['name'];
                $InnData['Status of verification of school by nodal'] = ucfirst($result['school']['application_status']);

                $school = $result['school'];

                $regions = \Models\SchoolRange::where('school_id', $school['id'])
                    ->where('range', '1-3')
                    ->select('id', 'regions')
                    ->first();

                $selected_region = [];

                if (count($regions) > 0) {
                    $selected_region = $regions['regions'];
                }

                $regions = \Models\Locality::select('name')
                    ->where('block_id', $school['sub_block_id'])
                    ->whereNotIn('id', [$school['locality_id']])
                    ->whereIn('id', $selected_region)
                    ->get();

                $sub_regions = \Models\Locality::select('name')
                    ->whereHas('block.district', function ($subQuery) use ($school) {
                        $subQuery = $subQuery->where('id', $school['district_id']);
                    })
                    ->where('block_id', '!=', $school['sub_block_id'])
                    ->whereNotIn('id', [$school['locality_id']])
                    ->whereIn('id', $selected_region)
                    ->get();

                $neighbours = [];

                foreach ($regions as $key => $locality) {

                    if (!empty($locality)) {

                        array_push($neighbours, $locality->name);
                    }
                }

                $sub_neighbours = [];

                foreach ($sub_regions as $key => $locality) {

                    if (!empty($locality)) {

                        array_push($sub_neighbours, $locality->name);
                    }
                }

                $InnData['Neighbouring wards(In Block)'] = implode(",  ", $neighbours);
                $InnData['Neighbouring wards(In District)'] = implode(",  ", $sub_neighbours);

                $items[] = $InnData;
            }
        }

        return $items;
    }

    private function getSchoolIdsBySession($request)
    {
        $schoolIds = [];

        $current_year = $this->data['latest_application_cycle']['session_year'];

        if (!empty($request->selectedCycle) && $request->selectedCycle != 'null') {

            $current_year = $request->selectedCycle;
        }

        $schoolIds = \Models\SchoolCycle::whereHas('application_cycle', function ($query) use ($current_year) {

            $query->where('session_year', $current_year);
        })
            ->pluck('school_id');

        return $schoolIds;
    }

    public function getSchoolAllottmentDetails($schoolId)
    {

        $school = \Models\School::where('id', $schoolId)->first();

        if (empty($school)) {
            throw new EntityNotFoundException('School with this UDISE Not found');
        }

        $allotmentData = \Helpers\SchoolHelper::getSchoolAllotment($school);

        return api('', $allotmentData);
    }

}
