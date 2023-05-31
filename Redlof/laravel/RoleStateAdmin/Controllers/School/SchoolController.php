<?php

namespace Redlof\RoleStateAdmin\Controllers\School;

use Exceptions\ActionFailedException;
use Exceptions\ValidationFailedException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Models\School;
use Models\SchoolAdmin;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;
use Redlof\RoleStateAdmin\Controllers\School\Requests\AddSchoolNeighbourhoodRequest;
use Redlof\RoleStateAdmin\Controllers\School\Requests\AddSchoolRequest;
use Redlof\RoleStateAdmin\Controllers\School\Requests\RecheckRequest;
use Redlof\RoleStateAdmin\Controllers\School\Requests\UpdateSchoolAdminDetails;

class SchoolController extends RoleStateAdminBaseController
{

    public function getRegisteredSchools(Request $request)
    {
        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('application_status', 'registered')
            ->where('state_id', $this->state_id)
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getVerifiedSchools(Request $request)
    {
        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('state_id', $this->state_id)
            ->where('application_status', 'verified')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getSearchRegisteredSchools(Request $request)
    {
        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('state_id', $this->state_id)
            ->where('application_status', 'registered')
            ->where(function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('udise', $request['s']);
            })
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('Showing Searched registered Schools', $schools);
    }

    public function getSearchVerifiedSchools(Request $request)
    {
        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('state_id', $this->state_id)
            ->where('application_status', 'verified')
            ->where(function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('udise', $request['s']);
            })
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('Showing Searched Verified Schools', $schools);
    }

    public function getDownloadSchools(Request $request)
    {
        ini_set('max_execution_time', 0);

        $current_year = $this->data['latest_application_cycle']['session_year'];

        if (!empty($request->selectedCycle) && $request->selectedCycle != 'null') {

            $current_year = $request->selectedCycle;
        }

        $schoolIds = $this->getSchoolIdsBySession($request);

        $query = \Models\School::where('state_id', $this->state_id)
            ->whereIn('id', $schoolIds)
            ->whereHas('schoolcycle.application_cycle', function (Builder $query) use ($current_year) {
                $query->where('session_year', $current_year);
            })
            ->with('locality', 'block', 'district', 'state', 'language', 'schooladmin.user', 'schoolcycle.application_cycle');

        if ($request->application_status) {

            $query->where('application_status', strtolower($request->application_status));
        }

        $all_schools = $query->get();

        $items = $this->getDownloadCsvData($all_schools, $request);

        $reports = \Excel::create('schools-list', function ($excel) use ($items) {

            $excel->sheet('Schools List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });
        })->store('csv', public_path('temp'));

        return response()->json(['filename' => 'schools-list.csv', 'data' => asset('temp/schools-list.csv')], 200);
    }

    public function postDownloadAppliedStudents(Request $request, $udise)
    {
        $school = \Models\School::where('udise', $udise)->first();

        if (empty($school)) {

            throw new ValidationFailedException("School Not found");
        }

        $school_id = $school->id;

        $students = \Models\RegistrationCycle::whereHas('application_details', function (Builder $query) {
            $query->where('session_year', '2020');
        })
            ->get();

        $reg_cycle_ids = [];

        foreach ($students as $student) {

            if (isset($student->preferences)) {

                foreach ($student->preferences as $pref) {

                    if ($pref == $school_id) {
                        array_push($reg_cycle_ids, $student->id);
                    }
                }
            }

            if (isset($student->nearby_preferences)) {

                foreach ($student->nearby_preferences as $prefer) {

                    if ($prefer == $school_id) {

                        array_push($reg_cycle_ids, $student->id);
                    }
                }
            }
        }

        $applied_student = \Models\RegistrationCycle::whereIn('id', $reg_cycle_ids)
            ->with('basic_details')
            ->whereHas('basic_details', function ($query) {

                $query->where('status', 'completed');
            })
            ->get();

        $items = [];

        if (count($applied_student) != 0) {

            foreach ($applied_student as $result) {

                $result = $result->toArray();

                $InnData['Registeration ID'] = $result['basic_details']['registration_no'];
                $InnData['Name'] = $result['basic_details']['first_name'] . ' ' . $result['basic_details']['last_name'];
                $InnData['DOB'] = $result['basic_details']['dob'];

                $items[] = $InnData;
            }
        }

        $reports = \Excel::create($udise . '-applied-students', function ($excel) use ($items, $udise) {

            $excel->sheet($udise . ' Applied Students', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });
        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => $udise . '-applied-students.xlsx', 'data' => asset('temp/' . $udise . '-applied-students.xlsx')], 200);
    }

    public function getSchoolAdminDetail($school_id)
    {
        $school_admin = SchoolAdmin::with('user')->where('school_id', $school_id)->first();

        return api('', $school_admin);
    }

    public function postSchoolAdminUpdate(UpdateSchoolAdminDetails $request)
    {

        $phone = \Models\User::where('phone', $request->phone)->where('id', '!=', $request->id)->first();

        if (!empty($phone)) {
            throw new ActionFailedException("Phone number is Already Exist");
        }

        $user = \Models\User::find($request->id);

        if ($user->phone != $request->phone) {
            $user->phone = $request->phone;
        }

        $user->username = $request->username ? $request->username : $user->username;

        $user->save();

        $apiData['reload'] = true;

        return api('Successfully Updated Details', $apiData);
    }

    public function postSchoolSeatInfoUpdate(Request $request, $udise)
    {

        if (empty($request[0]['total_seats'])) {
            throw new ValidationFailedException("Please enter total seats");
        }

        $school = \Models\School::where('udise', $udise)->first();

        $level = \Models\Level::where('level', $request[0]['level'])->first();

        $school_level_info = \Models\SchoolLevelInfo::where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->where('school_id', $school->id)
            ->where('level_id', $level->id)
            ->first();

        if ($school_level_info->total_seats > intval($request[0]['total_seats'])) {
            throw new ValidationFailedException("Seats cannot be less than current seat numbers");
        }

        $school_level_info->total_seats = $request[0]['total_seats'];

        $school_level_info->available_seats = $request[0]['available_seats'];

        $school_level_info->save();

        $apiData['reload'] = true;

        return api('Seat details updated successfully', $apiData);
    }

    public function postSchoolAdd(AddSchoolRequest $request, UserRepo $userRepo)
    {
        if ($request->hasFile('image')) {

            $file_name = \ImageHelper::createFileName($request['image']);

            \ImageHelper::ImageUploadToS3($request['image'], $file_name, 'school/', true, 1200, 600, true);

            $request->merge(['logo' => $file_name]);
        }

        $request->merge(['language_id' => 1]);
        $request->merge(['state_id' => $request['state']['id']]);
        $request->merge(['district_id' => $request['district_id']]);
        $request->merge(['block_id' => $request['block_id']]);
        $request->merge(['locality_id' => $request['locality_id']]);
        $request->merge(['sub_locality_id' => $request['sub_locality_id']]);
        $request->merge(['sub_sub_locality_id' => $request['sub_sub_locality_id']]);

        // $newSchool = School::create($request->all());

        // $newSchoolAdmin = new SchoolAdmin();

        // $newSchoolAdmin->school_id = $newSchool->id;
        // $request['role_type'] = 'role-school-admin';
        // $request['password'] = 'think201today';

        // $user = $userRepo->create($request);

        // $newSchoolAdmin->user_id = $user['id'];
        // $newSchoolAdmin->save();
        // $state = State::select('id', 'slug')->find($request['state']['id']);
        // $data['redirect'] = url('stateadmin/states/' . $state->slug . '/schools');

        // return api('New school ' . $newSchool->name . ' is added', $newSchool->name);
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

    public function postSchoolDelete($school_id)
    {

        $school = School::find($school_id);
        $school->delete();

        $redirect_state = route('stateadmin.school.getall');

        $showObject = [
            'redirect_state' => $redirect_state,
        ];

        return api($school->name . ' school deleted.', $showObject);
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

    public function getSchoolAllottmentDetails($schoolId)
    {

        $school = \Models\School::where('id', $schoolId)->first();

        if (empty($school)) {
            throw new EntityNotFoundException('School with this UDISE Not found');
        }

        $allotmentData = \Helpers\SchoolHelper::getSchoolAllotment($school);

        return api('', $allotmentData);
    }

    public function getSchoolSeatDetails($udise)
    {
        $school = School::where('udise', $udise)->select('id', 'levels')->first();

        $levels = \Models\Level::select('id', 'level')->whereIn('id', $school['levels'])->get();

        $stats = \Models\AllottmentStatistic::where('school_id', $school->id)
            ->whereIn('level_id', $school['levels'])
            ->get();

        $school_levels = \Models\SchoolLevelInfo::where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->where('school_id', $school->id)
            ->whereIn('level_id', $school['levels'])
            ->orderBy('created_at', 'asc')
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

                $legacy['available_seats'] = $school_levels->where('level_id', $level_id)->pluck('available_seats')->first();

                $legacy['total_seats'] = $school_levels->where('level_id', $level_id)->pluck('total_seats')->first();
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

    public function postStudentPhoneUpdate(Request $request)
    {

        if (!preg_match("/^\d+\.?\d*$/", $request->mobile) || strlen($request->mobile) != 10) {

            throw new ValidationFailedException("Please Enter Valid Mobile Number");
        }

        $student = \Models\RegistrationBasicDetail::find($request->id);

        if (!empty($student)) {

            $student->mobile = $request->mobile ? $request->mobile : $student->mobile;
            $student->first_name = $request->first_name ? $request->first_name : $student->first_name;
            $student->middle_name = $request->middle_name ? $request->middle_name : $student->middle_name;
            $student->last_name = $request->last_name ? $request->last_name : $student->last_name;

            $student->update();
        }

        $apiData['reload'] = true;

        return api('Successfully updated Student Phone', $apiData);
    }

    private function getDownloadCsvData($all_schools, $request)
    {

        $current_year = $this->data['latest_application_cycle']['session_year'];

        if (!empty($request->selectedCycle) && $request->selectedCycle != 'null') {

            $current_year = $request->selectedCycle;
        }

        $schoolIds = $all_schools->pluck('id')->toArray();

        $levels = \Models\Level::get()->groupBy('id')->toArray();

        $this_session_seats = \Models\SchoolLevelInfo::whereIn('school_id', $schoolIds)
            ->where('session_year', $current_year)
            ->get()
            ->groupBy('school_id');

        $all_regions = \Models\SchoolRange::whereIn('school_id', $schoolIds)
            ->where('range', '1-3')
            ->get()
            ->groupBy('school_id');

        $all_locations = array_column(\Models\Locality::orderBy('id', 'desc')->get()->toArray(), null, 'id');

        $items = [];

        if (count($all_schools) == 0) {
            return $items;
        }

        foreach ($all_schools as $schoolKey => $result) {

            $result = $result->toArray();

            $InnData['Registered School Name'] = $result['name'];
            $InnData['UDISE Code'] = $result['udise'];

            $InnData['Entry Class'] = '';
            $entry_class = isset($levels[$result['levels'][0]]) ? $levels[$result['levels'][0]][0] : null;
            $InnData['Entry Class'] = !empty($entry_class) ? $entry_class['level'] : 'NA';

            $InnData['School Contact'] = $result['phone'];
            $InnData['School Admin Contact'] = !empty($result['schooladmin']) && !empty($result['schooladmin']['user']) ? $result['schooladmin']['user']['phone'] : '';
            $InnData['School address'] = $result['address'];
            $InnData['District'] = $result['district']['name'];
            $InnData['Block'] = $result['block']['name'];
            $InnData['Ward/ Gram panchayat'] = $result['locality']['name'];

            $schoolregion = isset($all_regions[$result['id']]) ? $all_regions[$result['id']][0] : null;

            $neighbours = '';

            if (!empty($schoolregion) && count($schoolregion['regions']) > 0) {

                foreach ($schoolregion['regions'] as $key => $localityId) {

                    $locality = isset($all_locations[$localityId]) ? $all_locations[$localityId] : null;

                    if ($locality && $locality['id'] != $result['locality_id']) {

                        $neighbours = empty($neighbours) ? $locality['name'] : $neighbours . ', ' . $locality['name'];

                    }

                }
            }

            $InnData['Neighbouring wards(In Block)'] = $neighbours;

            $InnData['Total seats in the entry level class'] = 'NA';
            $InnData['Total seats under the 25% quota'] = 'NA';

            $schoolLevels = isset($this_session_seats[$result['id']]) ? $this_session_seats[$result['id']] : null;

            if (count($schoolLevels) > 0) {

                $seatInfo = array_column($schoolLevels->toArray(), null, 'level_id')[$result['levels'][0]] ?? null;

                $InnData['Total seats in the entry level class'] = !empty($seatInfo) ? $seatInfo['total_seats'] : 0;
                $InnData['Total seats under the 25% quota'] = !empty($seatInfo) ? $seatInfo['available_seats'] : 0;
            }

            $InnData['Session year'] = isset($result['schoolcycle'][0]) ? $result['schoolcycle'][0]['application_cycle']['session_year'] : 'NA';
            $InnData['Application cycle'] = isset($result['schoolcycle'][0]) ? $result['schoolcycle'][0]['application_cycle']['cycle'] : 'NA';

            $items[] = $InnData;

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

    public function postUpdateRegionDetials(AddSchoolNeighbourhoodRequest $request, $school_id)
    {

        $school = School::where('id', $school_id)->select('id', 'district_id', 'locality_id')->first();

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

        $data['reload'] = true;

        return api('Neighbourhood areas of the school have been saved successfully', $data);

    }

    public function postRecheckSchool(RecheckRequest $request, $school_id)
    {

        $school = School::where('id', $school_id)->with('schooladmin', 'schooladmin.user')->first();

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

}
