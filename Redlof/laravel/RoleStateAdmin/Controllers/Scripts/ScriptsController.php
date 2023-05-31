<?php

namespace Redlof\RoleStateAdmin\Controllers\Scripts;

use Exceptions\ActionFailedException;
use Exceptions\EntityNotFoundException;
use Illuminate\Http\Request;
use Models\ApplicationCycle;
use Models\School;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;
use Redlof\StateAdmin\Controllers\Scripts\Requests\AddStep2Request;

class ScriptsController extends RoleStateAdminBaseController
{
    public function scriptLandingPage()
    {
        $this->data['title'] = 'Scripts';

        $nodals = \Models\StateNodal::with('user')->get();

        $this->data['nodals'] = $nodals;

        return view('stateadmin::scripts.script', $this->data);
    }

    public function migrateSchoolsToNewCycle(Request $request, $status)
    {

        // Old application cycle

        $oldCycle = \Models\ApplicationCycle::where('session_year', $this->data['latest_application_cycle']->session_year - 1)
            ->where('is_latest', false)
            ->where('status', 'completed')
            ->first();

        $schools = School::where('application_status', $status)
            ->where('state_id', $this->state_id)
            ->get();

        foreach ($schools as $key => $school) {

            $count = \Models\SchoolCycle::where('school_id', $school->id)
                ->where('application_cycle_id', $this->data['latest_application_cycle']->id)
                ->count();

            if ($count != 0) {

                continue;
            }

            $schoolCycle = \Models\SchoolCycle::create([
                'school_id' => $school->id,
                'application_cycle_id' => $this->data['latest_application_cycle']->id,
                'status' => 'registered',
            ]);

            // Check for the school level info
            $existing_fee_details = \Models\SchoolLevelInfo::where('school_id', $school->id)
                ->where('session_year', $this->data['latest_application_cycle']->session_year)
                ->get();

            if (!$existing_fee_details->isEmpty()) {
                continue;
            }

            // Get school class levels
            $highest_class_id = \Helpers\SchoolHelper::getClassID($school->type);

            $entry_class_id = (int) $school->levels[0];

            $level_ids = \Models\Level::where('id', '>=', $entry_class_id)
                ->where('id', '<=', $highest_class_id)
                ->where('id', '<=', 18)
                ->pluck('id')
                ->toArray();

            $levels_to_add = [];

            foreach ($level_ids as $level_id) {

                // Get the last cycle data for this calls
                $levelData = \Models\SchoolLevelInfo::where('school_id', $school->id)
                    ->where('level_id', $level_id)
                    ->orderBy('id', 'desc')->first();

                $temp_level_info = [
                    'level_id' => $level_id,
                    'school_id' => $school->id,
                    'tution_fee' => $levelData ? $levelData->tution_fee : 0,
                    'other_fee' => $levelData ? $levelData->other_fee : 0,
                    'available_seats' => $levelData ? $levelData->available_seats : 0,
                    'total_seats' => $levelData ? $levelData->total_seats : 0,
                    'application_cycle_id' => $this->data['latest_application_cycle']->id,
                    'session_year' => $this->data['latest_application_cycle']->session_year,
                    'created_at' => \Carbon::now(),
                    'updated_at' => \Carbon::now(),
                ];

                $levels_to_add[] = $temp_level_info;
            }

            if ($levels_to_add) {
                \Models\SchoolLevelInfo::insert($levels_to_add);
            }

            $seatInfos = \Models\SchoolLevelInfo::where('school_id', $school->id)
                ->whereIn('level_id', $school['levels'])
                ->where('session_year', $this->data['latest_application_cycle']['session_year'])
                ->first();

            if (!empty($seatInfos)) {

                $schoolSeatInfo = [
                    'school_id' => $school->id,
                    'level_id' => $seatInfos->level_id,
                    'year' => $oldCycle->session_year,
                    'total_seats' => $seatInfos->total_seats,
                ];

                \Models\SchoolSeatInfo::create($schoolSeatInfo);
            }

            \Log::info($school->id);
        }

        return api('Schools migrated successfully');
    }

    public function removeDuplicateLevelEntries($type = false)
    {
        \Helpers\SchoolHelper::deleteDuplicateSchoolLevelInfos();

        return api('');
    }

    public function getSchoolsNotRegisteredInLatestAppCyc($type)
    {

        // Get the current year
        $year = $this->data['latest_application_cycle']->session_year;

        $application_cycle_ids = \Models\ApplicationCycle::where('session_year', $year)->pluck('id')->toArray();

        $latest_app_school_ids = \Models\SchoolCycle::whereIn('application_cycle_id', $application_cycle_ids)->pluck('school_id')->toArray();

        $schools = \Models\School::where('application_status', $type)
            ->whereNotIn('id', $latest_app_school_ids)
            ->whereHas('schoolcycle', function ($query) {
                $query->whereIn('application_cycle_id', [56, 57, 58]);
            })
            ->get();

        return api('', $schools);
    }

    public function postSchoolStatusCycles(Request $request)
    {

        // Get the past cycle
        $year = \Carbon::now()->year - 1;

        $applicationCycles = \Models\ApplicationCycle::where('session_year', $year)->pluck('id')->toArray();

        $schoolCycles = \Models\SchoolCycle::whereIn('application_cycle_id', $applicationCycles)
            ->with('school')
            ->get();

        foreach ($schoolCycles as $key => $schoolCycle) {

            $schoolCycle->status = $schoolCycle->school ? $schoolCycle->school->application_status : 'skipped';

            $schoolCycle->save();
        }

        return api('', $schoolCycles);
    }

    public function postSchoolCycleStatusUpdate(Request $request)
    {
        // Get the school cycle with shcool data for the current cycle
        $schoolCycles = \Models\SchoolCycle::where('application_cycle_id', $this->data['latest_application_cycle']->id)
            ->where('status', 'registered')
            ->with('school')
            ->get();

        $schools = [];

        foreach ($schoolCycles as $key => $schoolCycle) {

            if (!$schoolCycle->school) {
                \Log::info($schoolCycle->school_id);
                continue;
            }

            \Models\School::where('id', $schoolCycle->school->id)->update(['application_status' => "registered"]);

            array_push($schools, $schoolCycle->school->udise);
        }

        $data["schools"] = $schools;

        return api('Schools migrated successfully', $data);
    }

    public function getSchoolsRegisteredInLatestAppCycWithNullAvaliableSeats()
    {
        $application_cycle_ids = \Models\ApplicationCycle::where('session_year', 2021)->pluck('id')->toArray();

        $latest_app_school_ids = \Models\SchoolCycle::whereIn('application_cycle_id', $application_cycle_ids)->pluck('school_id')->toArray();

        $schools = \Models\School::where('application_status', 'verified')
            ->whereIn('id', $latest_app_school_ids)
            ->get()
            ->transform(function ($item, $key) {

                $info = \Models\SchoolLevelInfo::where('school_id', $item['id'])
                    ->where('session_year', $this->data['latest_application_cycle']['session_year'])
                    ->where('level_id', $item['levels'][0])
                    ->orderBy('created_at', 'DESC')
                    ->first();

                if (empty($info)) {

                    return $item;
                }

                if ($info->total_seats == null || $info->total_seats == 'null' || $info->total_seats == 0 || $info->available_seats == null || $info->available_seats == 'null' || $info->available_seats == 0) {

                    return $item;
                }
            })
            ->filter()
            ->values();

        return api('', $schools);
    }

    public function getRecheckSchool(Request $request)
    {
        $application_cycle_ids = \Models\ApplicationCycle::where('session_year', 2021)->pluck('id')->toArray();

        $latest_app_school_ids = \Models\SchoolCycle::whereIn('application_cycle_id', $application_cycle_ids)->pluck('school_id')->toArray();

        $query = \Models\School::where('application_status', 'recheck')
            ->whereIn('id', $latest_app_school_ids);

        if ($request->nodal_id) {

            $nodal_school_ids = \Models\SchoolNodal::where('nodal_id', $request->nodal_id)
                ->pluck('school_id')
                ->toArray();

            $query->whereIn('id', $nodal_school_ids);
        }

        $schools = $query->get();

        return api('', $schools);
    }

    public function postConvertRecheckSchoolToRegistered(Request $request)
    {
        $application_cycle_ids = \Models\ApplicationCycle::where('session_year', 2021)->pluck('id')->toArray();

        $latest_app_school_ids = \Models\SchoolCycle::whereIn('application_cycle_id', $application_cycle_ids)->pluck('school_id')->toArray();

        $query = \Models\School::where('application_status', 'recheck')
            ->whereIn('id', $latest_app_school_ids);

        if ($request->nodal_id) {

            $nodal_school_ids = \Models\SchoolNodal::where('nodal_id', $request->nodal_id)
                ->pluck('school_id')
                ->toArray();

            $query->whereIn('id', $nodal_school_ids);
        }

        $query->update(['application_status' => 'registered']);

        return api('Converted to Registered');
    }

    public function getSchool($udise)
    {
        $school = \Models\School::where('udise', $udise)
            ->with('schooladmin.user')
            ->first();

        if (empty($school)) {

            throw new EntityNotFoundException('School with this UDISE Not found');
        }

        $school->entry_levels = \Models\SchoolLevelInfo::with('level_info')
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->whereIn('level_id', $school->levels)
            ->where('school_id', $school->id)
            ->get();

        return api('', $school);
    }

    public function getCompleteSchool($udise)
    {
        $data = [];

        $data['school'] = \Models\School::where('id', $udise)
            ->orWhere('udise', $udise)
            ->with(['schooladmin.user', 'district'])
            ->first();

        if (empty($data['school'])) {

            throw new EntityNotFoundException('School with this UDISE Not found');
        }

        $data['school']['current_entry_class'] = \Models\Level::where('id', $data['school']['levels'][0])->first();

        $all_application_cycles = \Models\ApplicationCycle::orderBy('created_at', 'desc')->get();

        foreach ($all_application_cycles as $app_cyc) {

            $students = \Models\RegistrationCycle::where('application_cycle_id', $app_cyc->id)
                ->get();

            $students_count = 0;
            $only_students_count = 0;

            foreach ($students as $student) {

                if (!empty($student->preferences)) {

                    if (in_array($data['school']->id, $student->preferences)) {

                        $students_count++;

                        if (count($student->preferences) == 1 && empty($student->nearby_preferences)) {

                            $only_students_count++;
                        }

                        continue;
                    }
                }

                if (!empty($student->nearby_preferences)) {

                    if (in_array($data['school']->id, $student->nearby_preferences)) {

                        $students_count++;

                        if (count($student->nearby_preferences) == 1 && empty($student->preferences)) {

                            $only_students_count++;
                        }
                    }
                }
            }

            $app_cyc->no_reg_students = $students_count;

            $app_cyc->only_no_reg_students = $only_students_count;

            $app_cyc->entry_class = \Models\SchoolLevelInfo::where('session_year', $app_cyc->session_year)
                ->whereIn('level_id', $data['school']['levels'])
                ->where('school_id', $data['school']['id'])
                ->with('level_info')
                ->first();

            $app_cyc->school_cycle = \Models\SchoolCycle::where('school_id', $data['school']['id'])
                ->where('application_cycle_id', $app_cyc->id)
                ->first();

            $app_cyc->alloted_students = \Models\RegistrationCycle::where('allotted_school_id', $data['school']['id'])
                ->whereIn('status', ['allotted', 'enrolled'])
                ->where('application_cycle_id', $app_cyc->id)
                ->with(['basic_details'])
                ->distinct()
                ->get();

            $app_cyc->enrolled_students = \Models\RegistrationCycle::where('allotted_school_id', $data['school']['id'])
                ->where('status', 'enrolled')
                ->where('application_cycle_id', $app_cyc->id)
                ->with(['basic_details'])
                ->distinct()
                ->get();

            $app_cyc->dismissed_students = \Models\RegistrationCycle::where('allotted_school_id', $data['school']['id'])
                ->where('status', 'dismissed')
                ->where('application_cycle_id', $app_cyc->id)
                ->with(['basic_details'])
                ->distinct()
                ->get();
        }

        // Get school regions
        $regions = \Models\SchoolRange::where('school_id', $data['school']->id)
            ->where('range', '1-3')
            ->select('id', 'regions')
            ->first();

        $data['neighbourhood_wards'] = \Models\Locality::select('id', 'name')
            ->whereIn('id', $regions->regions)
            ->get();

        $data['school_nodal'] = \Models\SchoolNodal::where('school_id', $data['school']['id'])
            ->with('nodaladmin.user')
            ->first();

        $data['udise_nodal'] = \Models\UdiseNodal::where('udise', $udise)
            ->first();

        $data['school_district_admin'] = \Models\StateDistrictAdmin::where('district_id', $data['school']['district_id'])
            ->with('user')
            ->first();

        $data['all_application_cycles'] = $all_application_cycles;

        return api('', $data);
    }

    public function postSchoolAdminUpdate(Request $request)
    {
        $phone = \Models\User::where('phone', $request->phone)->where('id', '!=', $request->schooladmin['user_id'])->first();

        if (!empty($phone)) {
            throw new ActionFailedException("Phone number is Already Exist");
        }

        $user = \Models\User::find($request->schooladmin['user_id']);

        if ($user->phone != $request->phone) {
            $user->phone = $request->phone;
        }

        $school = \Models\School::where('id', $request->id)->first();

        if ($school) {

            $school->phone = $request->phone;

            $school->save();
        }

        $user->save();

        // update seats
        if (!empty($request->entry_levels)) {

            foreach ($request->entry_levels as $el) {

                $old_data = \Models\SchoolLevelInfo::where('id', $el['id'])
                    ->where('session_year', $this->data['latest_application_cycle']['session_year'])
                    ->first();

                if ($old_data->total_seats > $el['total_seats']) {

                    throw new EntityNotFoundException('Cannot decrease total seats');
                }

                if ($old_data->available_seats < $el['available_seats']) {

                    \Models\AllottmentStatistic::whereHas('application_cycle', function ($s_query) {

                        $s_query->where('session_year', $this->data['latest_application_cycle']['session_year']);
                    })
                        ->where('school_id', $old_data->school_id)
                        ->update(['full_house' => false]);
                }

                $old_data->total_seats = $el['total_seats'];

                $old_data->available_seats = $el['available_seats'];

                $old_data->save();
            }
        }

        return api('Successfully Updated Details');
    }

    public function postMapSchoolToNodal()
    {
        $nodal_school_ids = \Models\SchoolNodal::pluck('school_id')->toArray();

        $schools = \Models\SchoolCycle::whereNotIn('school_id', $nodal_school_ids)
            ->with('school')
            ->get();

        foreach ($schools as $school) {

            if ($school->school['application_status'] != 'applied') {
                $this->mapNodal($school->school);
            }
        }

        return api('successful');
    }

    private function mapNodal($school)
    {

        $checkUdise = \Models\UdiseNodal::where('udise', $school['udise'])
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

                        $alreadyassigned = \Models\SchoolNodal::where('school_id', $school['id'])->first();

                        if (empty($alreadyassigned)) {

                            $newSchoolDetails = new \Models\SchoolNodal();

                            $newSchoolDetails['school_id'] = $school['id'];

                            $newSchoolDetails['nodal_id'] = $nodalAdmin->id;

                            $newSchoolDetails->save();
                        }
                    }
                }
            }
        }

        return true;
    }

    public function postDownloadDuplicateUdiseSchools(Request $request)
    {
        $duplicat_school_ids = \Models\School::get()
            ->groupBy('udise')
            ->map(function ($item) {

                if (count($item) > 1) {

                    return $item->pluck('id')->toArray();
                }
            })
            ->filter()
            ->values();

        $school_ids = [];

        foreach ($duplicat_school_ids as $x) {

            foreach ($x as $y) {

                array_push($school_ids, $y);
            }
        }

        $all_schools = \Models\School::orderBy('udise', 'desc')
            ->whereIn('id', $school_ids)
            ->get();

        $items = $this->getDownloadCsvData($all_schools);

        $reports = \Excel::create('duplicate-udise-schools-list', function ($excel) use ($items) {

            $excel->sheet('Duplicate Udise Schools List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });
        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'duplicate-udise-schools-list.xlsx', 'data' => asset('temp/duplicate-udise-schools-list.xlsx')], 200);
    }

    private function getDownloadCsvData($all_schools)
    {

        $items = [];

        if (count($all_schools) != 0) {

            foreach ($all_schools as $school) {

                $school = $school->toArray();

                $InnData['UDISE Code'] = $school['udise'];

                $InnData['School ID'] = $school['id'];

                $InnData['School Name'] = $school['name'];

                $InnData['Application status'] = $school['application_status'];

                $InnData['Created At'] = $school['created_at'];

                $InnData['Updated At'] = $school['updated_at'];

                $items[] = $InnData;
            }
        }

        return $items;
    }

    public function getStudentsSelectedSchoolInPreferrence($udise = null)
    {
        $school = \Models\School::where('udise', $udise)->first();

        if (empty($school)) {

            throw new EntityNotFoundException('School not found');
        }

        $students = \Models\RegistrationCycle::where('application_cycle_id', $this->data['latest_application_cycle']->id)
            ->with('basic_details')
            ->get();

        $selected_students = [];

        foreach ($students as $student) {

            if (!empty($student->preferences)) {

                if (in_array($school->id, $student->preferences)) {

                    $selected_students[] = [
                        'registration_id' => $student->registration_id,
                        'registration_no' => $student->basic_details->registration_no,
                        'name' => $student->basic_details->first_name,
                        'mobile' => $student->basic_details->mobile,
                        'email' => $student->basic_details->email,
                    ];

                    continue;
                }
            }

            if (!empty($student->nearby_preferences)) {

                if (in_array($school->id, $student->nearby_preferences)) {

                    $selected_students[] = [
                        'registration_id' => $student->registration_id,
                        'registration_no' => $student->basic_details->registration_no,
                        'name' => $student->basic_details->first_name,
                        'mobile' => $student->basic_details->mobile,
                        'email' => $student->basic_details->email,
                    ];
                }
            }
        }

        return api('students', $selected_students);
    }

    public function getStudentsSelectedSchoolInPreferrenceDownload($app_cyc_id, $udise = null)
    {
        $school = \Models\School::where('udise', $udise)->first();

        if (empty($school)) {

            throw new EntityNotFoundException('School not found');
        }

        $students = \Models\RegistrationCycle::where('application_cycle_id', $app_cyc_id)
            ->with(['basic_details.personal_details.district', 'basic_details.personal_details.block'])
            ->get();

        $selected_students = [];

        foreach ($students as $student) {

            if (!empty($student->preferences)) {

                if (in_array($school->id, $student->preferences)) {

                    if (count($student->preferences) == 1 && empty($student->nearby_preferences)) {

                        $selected_students[] = [
                            'registration_id' => $student->registration_id,
                            'registration_no' => $student->basic_details->registration_no,
                            'name' => $student->basic_details->first_name,
                            'mobile' => $student->basic_details->mobile,
                            'email' => $student->basic_details->email,
                            'district' => $student->basic_details->personal_details->district->name,
                            'block' => $student->basic_details->personal_details->block->name,
                        ];

                        continue;
                    }
                }
            }

            if (!empty($student->nearby_preferences)) {

                if (in_array($school->id, $student->nearby_preferences)) {

                    if (count($student->nearby_preferences) == 1 && empty($student->preferences)) {

                        $selected_students[] = [
                            'registration_id' => $student->registration_id,
                            'registration_no' => $student->basic_details->registration_no,
                            'name' => $student->basic_details->first_name,
                            'mobile' => $student->basic_details->mobile,
                            'email' => $student->basic_details->email,
                            'district' => $student->basic_details->personal_details->district->name,
                            'block' => $student->basic_details->personal_details->block->name,
                        ];
                    }
                }
            }
        }

        $reports = \Excel::create('once-applied-students', function ($excel) use ($selected_students) {

            $excel->sheet('Once applied students', function ($sheet) use ($selected_students) {
                $sheet->fromArray($selected_students);
            });
        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'once-applied-students.xlsx', 'data' => asset('temp/once-applied-students.xlsx')], 200);
    }

    public function getStudentsSelectedSchoolInPreferrenceReplace($udise = null, $replace_udise = null)
    {
        $school = \Models\School::where('udise', $udise)->first();

        if (empty($school)) {

            throw new EntityNotFoundException('School not found');
        }

        $replace_school = \Models\School::where('udise', $replace_udise)->first();

        if (empty($replace_school)) {

            throw new EntityNotFoundException('New School not found');
        }

        $students = \Models\RegistrationCycle::where('application_cycle_id', $this->data['latest_application_cycle']->id)
            ->with('basic_details')
            ->get();

        foreach ($students as $student) {

            if (!empty($student->preferences)) {

                if (in_array($school->id, $student->preferences)) {

                    $preferences = $student->preferences;

                    $preferences = array_replace($preferences, array_fill_keys(array_keys($preferences, $school->id), (string) $replace_school->id));

                    $update_pref = \Models\RegistrationCycle::where('id', $student->id)->first();
                    $update_pref->preferences = $preferences;
                    $update_pref->save();
                }
            }

            if (!empty($student->nearby_preferences)) {

                if (in_array($school->id, $student->nearby_preferences)) {

                    $nearby_preferences = $student->nearby_preferences;

                    $nearby_preferences = array_replace($nearby_preferences, array_fill_keys(array_keys($nearby_preferences, $school->id), (string) $replace_school->id));

                    $update_near_pref = \Models\RegistrationCycle::where('id', $student->id)->first();
                    $update_near_pref->nearby_preferences = $nearby_preferences;
                    $update_near_pref->save();
                }
            }
        }

        $selected_students = $this->getStudentsSelectedSchoolInPreferrence($udise);

        $selected_students = json_decode($selected_students->content(), true);

        $selected_students = $selected_students['data'];

        return api('Students preferrences updated.', $selected_students);
    }

    public function getAllSearchedStudent($stu_data)
    {

        $student = \Models\RegistrationBasicDetail::orderBy('created_at', 'desc')
            ->where('registration_no', $stu_data)
            ->with([
                'registration_cycle',
                'personal_details.block',
                'personal_details.district',
                'personal_details.locality',
            ])
            ->first();

        if (empty($student)) {
            throw new EntityNotFoundException('Student does not exists.');
        }

        $studentCycle = \Models\RegistrationCycle::where('registration_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $student['registration_cycle'] = $studentCycle;

        // Get all the schools from the prefered option
        $preferedSchools = $student->registration_cycle->preferences ? $student->registration_cycle->preferences : [];

        $nearSchools = $student->registration_cycle->nearby_preferences ? $student->registration_cycle->nearby_preferences : [];

        $schools = array_merge($preferedSchools, $nearSchools);

        $schools = \Models\School::select('id', 'udise', 'name', 'school_type', 'levels')
            ->whereIn('id', $schools)
            ->get();

        if (count($schools) <= 0) {
            throw new EntityNotFoundException('No schools are selected');
        }

        $schoolsData = [];

        foreach ($schools as $key => $school) {

            $school['total_seats'] = 0;
            $school['allotted_seats'] = 0;
            $school['available_seats'] = 0;

            if (in_array((string) $school['id'], $student->registration_cycle->preferences ? $student->registration_cycle->preferences : [])) {
                $school['preferences'] = 'Preference';
            }

            if (in_array((string) $school['id'], $student->registration_cycle->nearby_preferences ? $student->registration_cycle->nearby_preferences : [])) {
                $school['preferences'] = 'Near By';
            }

            // Get the available seats
            $levelInfo = \Models\SchoolLevelInfo::where('school_id', $school['id'])
                ->where('level_id', $student->level_id)
                ->orderBy('created_at', 'DESC')
                ->with('level_info')
                ->first();

            if (empty($levelInfo)) {continue;}

            // Get the allotted count and check if allotted seats are more than
            $allotmentStats = \Models\AllottmentStatistic::where('school_id', $school['id'])
                ->where('level_id', $student->level_id)
                ->where('application_cycle_id', $student->registration_cycle->application_cycle_id)
                ->first();

            if (!empty($allotmentStats)) {
                $school['allotted_seats'] = $allotmentStats->allotted_seats;
            }

            $school['total_seats'] = $levelInfo->available_seats;
            $school['available_seats'] = $levelInfo->available_seats - $school['allotted_seats'];

            array_push($schoolsData, $school);
        }

        if (isset($student->registration_cycle->preferences[0])) {

            $student->nodal = \Models\SchoolNodal::where('school_id', $student->registration_cycle->preferences[0])
                ->with('nodaladmin.user')
                ->first();

        } else {

            if (isset($student->registration_cycle->nearby_preferences[0])) {

                $student->nodal = \Models\SchoolNodal::where('school_id', $student->registration_cycle->nearby_preferences[0])
                    ->with('nodaladmin.user')
                    ->first();

            }
        }

        $student['schools'] = $schoolsData;

        return api("", $student);
    }

    public function getStudentsNotSchools()
    {

        $students = \Models\RegistrationBasicDetail::orderBy('created_at', 'desc')
            ->where('status', 'completed')
            ->whereHas('registration_cycle', function ($query) {
                $query->where('application_cycle_id', $this->data['latest_application_cycle']['id']);
                $query->whereNull('preferences');
                $query->whereNull('nearby_preferences');
            })
            ->with([
                'registration_cycle',
                'personal_details.block',
                'personal_details.district',
                'personal_details.locality',
            ])->get();

        return api("", $students);
    }

    public function postStudentStatusUpdate(Request $request)
    {
        $student = \Models\RegistrationCycle::where('registration_id', $request->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (empty($student)) {

            throw new EntityNotFoundException('Student details not found');
        }

        $student->status = $request->registration_cycle['status'];

        if ($request->registration_cycle['status'] == 'applied') {

            $student->document_verification_status = null;
            $student->doc_reject_reason = null;
        }

        if ($request->registration_cycle['status'] == 'rejected') {

            $student->document_verification_status = 'rejected';
            $student->doc_reject_reason = null;
        }

        if ($request->registration_cycle['document_verification_status']) {

            $student->document_verification_status = $request->registration_cycle['document_verification_status'];
        }

        $student->save();

        $data['reload'] = true;

        return api("Status updated successfully", $data);
    }

    public function postStudentCategoryUpdate(AddStep2Request $request)
    {
        $currentDate = \Carbon::now();

        $student = \Models\RegistrationBasicDetail::where('registration_no', $request->registration_no)->first();

        if (empty($student)) {

            throw new EntityNotFoundException('Student details not found');
        }

        $parentDetails = \Models\RegistrationPersonalDetail::where('registration_id', $student->id)->first();

        if (empty($parentDetails)) {

            throw new EntityNotFoundException('Student details not found');
        }

        if ($request->category == 'ews' && $request->certificate_details['ews_type'] == 'income_certificate') {

            if (!isset($request->certificate_details['bpl_cerificate_date'])) {
                throw new EntityNotFoundException("Please Enter Certificatie Date");
            }
            if (!isset($request->certificate_details['bpl_cerificate_month'])) {
                throw new EntityNotFoundException("Please Enter Certificatie Month");
            }
            if (!isset($request->certificate_details['bpl_cerificate_year'])) {
                throw new EntityNotFoundException("Please Enter Certificatie Year");
            }

            $certificateDate = $request->certificate_details['bpl_cerificate_year'] . '/' . $request->certificate_details['bpl_cerificate_month'] . '/' . $request->certificate_details['bpl_cerificate_date'];

            $certificateDate = \Carbon::parse($certificateDate);

            if ($certificateDate->diffInMonths($currentDate) > 11) {
                throw new EntityNotFoundException("Income certificate date should be within 12 months from the current date");
            }

            if ($certificateDate->gt($currentDate)) {
                throw new EntityNotFoundException("Income certificate date should not be grater than the current date");
            }
        }

        if ($request->category == 'dg' && $request->certificate_details['dg_type'] == 'obc') {
            if (!isset($request->certificate_details['dg_cerificate_date'])) {
                throw new EntityNotFoundException("Please Enter Certificatie Date");
            }
            if (!isset($request->certificate_details['dg_cerificate_month'])) {
                throw new EntityNotFoundException("Please Enter Certificatie Month");
            }
            if (!isset($request->certificate_details['dg_cerificate_year'])) {
                throw new EntityNotFoundException("Please Enter Certificatie Year");
            }

            // Date should within six month from current date

            $certificateDate = $request->certificate_details['dg_cerificate_year'] . '-' . $request->certificate_details['dg_cerificate_month'] . '-' . $request->certificate_details['dg_cerificate_date'];

            $certificateDate = \Carbon::parse($certificateDate);

            if ($certificateDate->diffInMonths($currentDate) > 11) {
                throw new EntityNotFoundException("Income certificate date should be within 12 months from the current date");
            }

            if ($certificateDate->gt($currentDate)) {
                throw new EntityNotFoundException("Income certificate date should not be grater than the current date");
            }
        }

        $parentDetails->category = $request->category;

        $parentDetails->certificate_details = $request->certificate_details;

        $parentDetails->save();

        $data['reload'] = true;

        return api("Category updated successfully", $data);
    }

    public function postStudentDOBUpdate(Request $request)
    {

        if (empty($request->dob)) {
            throw new EntityNotFoundException('Please select the date of birth');
        }

        $student = \Models\RegistrationBasicDetail::where('id', $request->id)->first();

        if (empty($student)) {

            throw new EntityNotFoundException('Student details not found');
        }

        $dob = \Carbon::createFromDate($request->dob['year'], $request->dob['month'], $request->dob['date'], 'Asia/Kolkata');

        $current_year = \Carbon::now()->year;

        $n_l = \Carbon::createFromDate($current_year - 5, 4, 1, 'Asia/Kolkata')->startOfDay();
        $n_u = \Carbon::createFromDate($current_year - 3, 3, 31, 'Asia/Kolkata')->endOfDay();

        $c_l = \Carbon::createFromDate($current_year - 6, 4, 1, 'Asia/Kolkata')->startOfDay();
        $c_u = \Carbon::createFromDate($current_year - 5, 3, 31, 'Asia/Kolkata')->endOfDay();

        $level = \Models\Level::select('id', 'level')->find($student->level_id);

        $final_year = \Carbon::now()->subYears(3)->format('Y');
        $inter_year = \Carbon::now()->subYears(5)->format('Y');
        $ini_year = \Carbon::now()->subYears(6)->format('Y');

        if ($level->level == 'Pre-Primary') {

            if ($dob->lt($n_l) || $dob->gt($n_u)) {
                throw new EntityNotFoundException("For Pre-Primary admission, child should be been born on or after 1st April " . $inter_year . " and on or before 31 March " . $final_year);
            }
        }

        if ($level->level == 'Class 1') {

            if ($dob->lt($c_l) || $dob->gt($c_u)) {
                throw new EntityNotFoundException("For Class 1 admission, the child should have been born on or after 1st April " . $ini_year . " and on or before 31 March " . $inter_year);
            }
        }

        $student->dob = $dob;

        $student->save();

        $data['reload'] = true;

        return api("DOB updated successfully", $data);
    }

    public function getRegistratonStep2(Request $request)
    {
        $registration_no = $request->registration_no;

        $parent_type = [];
        $parent_type['father'] = false;
        $parent_type['mother'] = false;
        $parent_type['guardian'] = false;

        $parentDetails = \Models\RegistrationParentDetail::select('parent_type', 'parent_mobile_no', 'parent_profession', 'parent_name')
            ->whereHas('basic_details', function ($query) use ($registration_no) {
                $query->where('registration_no', $registration_no);
            })
            ->get();

        if (!count($parentDetails)) {

            $parent_type['father'] = true;
        }

        if (empty($parentDetails)) {
            $parentDetails = (object) [];
        }

        $personalInfo = \DB::select("SELECT category,certificate_details from registration_personal_details,registration_basic_details where registration_personal_details.registration_id=registration_basic_details.id and registration_no = '" . $registration_no . "'");

        if (!empty($personalInfo)) {
            $personalInfo = $personalInfo[0];
            $personalInfo->certificate_details = (array) (json_decode($personalInfo->certificate_details));
            if (isset($personalInfo->certificate_details['bpl_income'])) {
                $personalInfo->certificate_details['bpl_income'] = (int) $personalInfo->certificate_details['bpl_income'];
            }
            if (isset($personalInfo->certificate_details['bpl_cerificate_date'])) {
                $personalInfo->certificate_details['bpl_cerificate_date'] = (int) $personalInfo->certificate_details['bpl_cerificate_date'];
            }
            if (isset($personalInfo->certificate_details['bpl_cerificate_year'])) {
                $personalInfo->certificate_details['bpl_cerificate_year'] = (int) $personalInfo->certificate_details['bpl_cerificate_year'];
            }
            if (isset($personalInfo->certificate_details['bpl_cerificate_month'])) {
                $personalInfo->certificate_details['bpl_cerificate_month'] = (int) $personalInfo->certificate_details['bpl_cerificate_month'];
            }
            if (isset($personalInfo->certificate_details['dg_cerificate_date'])) {
                $personalInfo->certificate_details['dg_cerificate_date'] = (int) $personalInfo->certificate_details['dg_cerificate_date'];
            }
            if (isset($personalInfo->certificate_details['dg_cerificate_year'])) {
                $personalInfo->certificate_details['dg_cerificate_year'] = (int) $personalInfo->certificate_details['dg_cerificate_year'];
            }
            if (isset($personalInfo->certificate_details['dg_cerificate_month'])) {
                $personalInfo->certificate_details['dg_cerificate_month'] = (int) $personalInfo->certificate_details['dg_cerificate_month'];
            }
        } else {
            $personalInfo = (object) [];
        }

        foreach ($parentDetails as $key => $parentDetail) {
            $parent_type[$parentDetail['parent_type']] = true;
            $personalInfo->{$parentDetail['parent_type']} = $parentDetail;
        }
        $personalInfo->registration_no = $registration_no;
        $personalInfo->parent_type = $parent_type;

        return api('', $personalInfo);
    }

    public function postManualTriggerLottery(Request $request)
    {
        $msg = 'lottery started';
        \Log::info($msg);

        ini_set('max_execution_time', 0);

        $year = $this->data['latest_application_cycle']['session_year'];

        $app_cycles = \Models\ApplicationCycle::where('session_year', $year)
            ->orderBy('created_at', 'asc')
            ->get();

        $allotted_students = [];

        $studentIDs = $this->getStudentIdsBySession();

        foreach ($app_cycles as $cyc) {

            $students = \Models\RegistrationCycle::with('basic_details')
                ->where('application_cycle_id', $cyc->id)
                ->whereIn('id', $studentIDs['registration_cycle_id'])
                ->where('status', 'applied')
                ->where('document_verification_status', 'verified')
                ->whereHas('basic_details', function ($query) {
                    $query->where('status', 'completed');
                })
                ->get();

            if (empty($students)) {
                continue;
            }

            $msg = 'lottery cycle ' . $cyc->cycle . ' applied student ' . count($students);
            \Log::info($msg);

            foreach ($students as $registration_cycle) {

                if (in_array($registration_cycle->basic_details->registration_no, $allotted_students)) {
                    continue;
                }

                $applicable_schools = ['co-educational'];

                if ($registration_cycle->basic_details->gender == 'female') {

                    array_push($applicable_schools, 'girls');

                } elseif ($registration_cycle->basic_details->gender == 'male') {

                    array_push($applicable_schools, 'boys');

                }

                if (!empty($registration_cycle->preferences)) {

                    foreach ($registration_cycle->preferences as $key => $preference) {

                        $school = \Models\School::where('id', $preference)->first();

                        if (empty($school)) {
                            continue;
                        }

                        $schoolLevelInfo = $this->getSchoolLevel($school->id, $school->levels, $registration_cycle->basic_details->level_id, $cyc);

                        if (empty($schoolLevelInfo)) {
                            continue;
                        }

                        if (empty($schoolLevelInfo->school)) {
                            continue;
                        }

                        if (!in_array($schoolLevelInfo->school->school_type, $applicable_schools)) {
                            continue;
                        }

                        $allotmentStatistic = \Models\AllottmentStatistic::firstOrCreate(
                            [
                                'school_id' => $preference,
                                'level_id' => $registration_cycle->basic_details->level_id,
                                'application_cycle_id' => $registration_cycle->application_cycle_id,
                                'year' => $cyc->session_year,
                            ],
                            [
                                'allotted_seats' => 0,
                                'year' => now()->year,
                            ]
                        );

                        $allotmentStatistic->allotted_seats = $allotmentStatistic->allotted_seats + 1;
                        $allotmentStatistic->save();

                        \Models\RegistrationCycle::where('id', $registration_cycle->id)->update([
                            'allotted_school_id' => $school->id,
                            'status' => 'allotted',
                        ]);

                        array_push($allotted_students, $registration_cycle->basic_details->registration_no);

                        $msg = 'lottery cycle ' . $cyc->cycle . ' allotted student ' . $registration_cycle->basic_details->registration_no;
                        \Log::info($msg);
                        break;
                    }
                }

                if (!empty($registration_cycle->nearby_preferences) && !in_array($registration_cycle->basic_details->registration_no, $allotted_students)) {

                    foreach ($registration_cycle->nearby_preferences as $key => $nearby_preference) {

                        $school = \Models\School::where('id', $nearby_preference)->first();

                        if (empty($school)) {
                            continue;
                        }

                        $schoolLevelInfo = $this->getSchoolLevel($school->id, $school->levels, $registration_cycle->basic_details->level_id, $cyc);

                        if (empty($schoolLevelInfo)) {
                            continue;
                        }

                        if (empty($schoolLevelInfo->school)) {
                            continue;
                        }

                        if (!in_array($schoolLevelInfo->school->school_type, $applicable_schools)) {
                            continue;
                        }

                        $allotmentStatistic = \Models\AllottmentStatistic::firstOrCreate(
                            [
                                'school_id' => $nearby_preference,
                                'level_id' => $registration_cycle->basic_details->level_id,
                                'application_cycle_id' => $registration_cycle->application_cycle_id,
                                'year' => $cyc->session_year,
                            ],
                            [
                                'allotted_seats' => 0,
                                'year' => now()->year,
                            ]
                        );

                        $allotmentStatistic->allotted_seats = $allotmentStatistic->allotted_seats + 1;
                        $allotmentStatistic->save();

                        \Models\RegistrationCycle::where('id', $registration_cycle->id)->update([
                            'allotted_school_id' => $school->id,
                            'status' => 'allotted',
                        ]);

                        array_push($allotted_students, $registration_cycle->basic_details->registration_no);

                        $msg = 'lottery cycle ' . $cyc->cycle . ' allotted student ' . $registration_cycle->basic_details->registration_no;
                        \Log::info($msg);
                        break;
                    }
                }
            }

            $count = collect($allotted_students)->count();
            $msg = 'lottery completed cycle ' . $cyc->cycle . ' allotted students ' . $count;
            \Log::info($msg);
        }

        $count = collect($allotted_students)->count();
        $msg = 'lottery completed, total allotted students ' . $count;
        \Log::info($msg);

        return api('Student allotment is done');
    }

    public function postLotteryAnalysis()
    {
        ini_set('max_execution_time', 0);

        // $studs = \Models\RegistrationCycle::select('id', 'updated_at', 'status')->where('status', 'enrolled')->whereNull('enrolled_on')->get()->toArray();

        // foreach ($studs as $stud) {

        //     \Models\RegistrationCycle::where('id', $stud['id'])->update(['enrolled_on' => $stud['updated_at']]);
        // }

        // dd('done');

        $studentAllottedInMultipleCycles = \Helpers\PostLotteryAnalysisHelper::studentAllottedInMultipleCycles($this->data['latest_application_cycle']['id']);

        $schoolAllotedMoreThanAvailableSeats = \Helpers\PostLotteryAnalysisHelper::schoolAllotedMoreThanAvailableSeats($this->data['latest_application_cycle']['id']);

        $schoolSeatsAvaliableStudentNotAllotted = \Helpers\PostLotteryAnalysisHelper::schoolSeatsAvaliableStudentNotAllotted($this->data['latest_application_cycle']['id']);

        $data = [
            'studentAllottedInMultipleCycles' => $studentAllottedInMultipleCycles,
            'schoolAllotedMoreThanAvailableSeats' => $schoolAllotedMoreThanAvailableSeats,
            'schoolSeatsAvaliableStudentNotAllotted' => $schoolSeatsAvaliableStudentNotAllotted,
        ];

        return api('Post lottery analysis', $data);
    }

    private function getSchoolLevel($school_id, $school_levels, $student_level_id, $applicationCycle)
    {

        $school_seats = 0;

        $school_level = \Models\SchoolLevelInfo::where('school_id', $school_id)
            ->whereHas('school', function ($s_query) use ($student_level_id) {

                $dynamic_match = '"' . $student_level_id . '"';

                $s_query->where('application_status', 'verified')
                    ->whereRaw("levels @> " . "'" . $dynamic_match . "'");
            })
            ->where('session_year', $applicationCycle->session_year)
            ->whereIn('level_id', $school_levels)
            ->orderBy('created_at', 'DESC')
            ->with('school')
            ->first();

        if ($school_level) {

            $school_seats = $school_level->available_seats;

            $school_allotted_seats = \Models\RegistrationCycle::whereHas('application_details', function ($s_query) use ($applicationCycle) {

                $s_query->where('session_year', $applicationCycle->session_year);
            })
                ->where('allotted_school_id', $school_id)
                ->whereIn('status', ['allotted', 'enrolled'])
                ->count();

            $school_seats = $school_seats - $school_allotted_seats;
        }

        if ($school_seats) {

            return $school_level;
        }

        return null;
    }

    private function getStudentIdsBySession()
    {
        $current_year = $this->data['latest_application_cycle']['session_year'];

        $students = \Models\RegistrationCycle::whereHas('application_details', function ($query) use ($current_year) {

            $query->where('session_year', $current_year);
        })
            ->get();

        $studentIDs = [
            'registration_id' => $students->pluck('registration_id')->toArray(),
            'registration_cycle_id' => $students->pluck('id')->toArray(),
        ];

        if ($this->data['latest_application_cycle']['cycle'] > 1) {

            // get users which registered for second cycle
            // remove there first cycle entry

            $usersUnique = $students->unique('registration_id');

            $usersDupesRegistrationId = $students->diff($usersUnique)->pluck('id')->toArray();

            $delStudentIds = $students->whereIn('id', $usersDupesRegistrationId)
                ->where('cycle', '<', $this->data['latest_application_cycle']['cycle'])
                ->pluck('id')
                ->toArray();

            $students = $students->whereNotIn('id', $delStudentIds);

            $studentIDs = [
                'registration_id' => $students->pluck('registration_id')->toArray(),
                'registration_cycle_id' => $students->pluck('id')->toArray(),
            ];
        }

        return $studentIDs;
    }

    public function getStateSubLocality(Request $request, $schoolId)
    {

        if (strlen($request['keyword']) < 2) {
            return api('', []);
        }

        $school = \Models\School::where('id', $schoolId)
            ->select('id', 'state_id', 'block_id', 'locality_id', 'district_id')
            ->first();

        $schoolLocalities = \Models\SchoolRange::where('school_id', $school->id)
            ->where('range', '1-3')
            ->select('id', 'regions')
            ->first();

        $subLocalities = \Models\Locality::select('id', 'name', 'block_id')
        // ->where('name', 'ilike', '%' . $request['keyword'] . '%')
            ->whereHas('block.district.state', function ($subQuery) use ($school) {
                $subQuery = $subQuery->where('id', $school->state_id);
            })
            ->whereHas('block', function ($subQuery) use ($request) {
                $subQuery->where('name', 'ilike', '%' . $request['keyword'] . '%');
            })
            ->whereNotIn('id', [$school->locality_id])
            ->whereNotIn('id', $schoolLocalities->regions)
            ->with(['block'])
            ->get();

        return api('', $subLocalities);
    }

    public function postAddSchoolSubLocality(Request $request, $schoolId)
    {

        if (empty($request->locality_id)) {
            throw new EntityNotFoundException('Please select the locality');
        }

        $school = \Models\School::where('id', $schoolId)
            ->select('id', 'state_id', 'block_id', 'locality_id', 'district_id')
            ->first();

        $schoolLocalities = \Models\SchoolRange::where('school_id', $school->id)
            ->where('range', '1-3')
            ->select('id', 'regions')
            ->first();

        $localities = $schoolLocalities->regions;

        array_push($localities, $request->locality_id);

        $newSchoolRange = \Models\SchoolRange::updateOrCreate(
            [
                'school_id' => $school->id,
                'range' => '1-3',
                'type' => 'district',
            ],
            ['regions' => $localities]
        );

        $data["reload"] = true;

        $data['range'] = $newSchoolRange;

        return api('Sublocality added successfully.', $data);

    }

    public function postAllotStudentSeat(Request $request, $registrationId)
    {

        $applicationCycle = $this->data['latest_application_cycle'];
        $isAllotted = false;

        // Get the student details
        $registration = \Models\RegistrationCycle::whereHas('application_details', function ($sub_query) use ($applicationCycle, $registrationId) {
            $sub_query->where('session_year', $applicationCycle->session_year);
        })
            ->where('registration_id', $registrationId)
            ->where('status', 'applied')
            ->where('document_verification_status', 'verified')
            ->with('basic_details')
            ->first();

        if (empty($registration)) {
            throw new EntityNotFoundException('Registration not found or application is not in applied state.');
        }

        if (count($registration->preferences) <= 0) {
            throw new EntityNotFoundException('The are no schools selected in the preferences.');
        }

        // Loop through each preferences
        for ($prefIndex = 0; $prefIndex <= count($registration->preferences); $prefIndex++) {

            $schoolId = $registration->preferences[$prefIndex];

            // Get the schools level info
            $school = \Models\School::select('id', 'school_type', 'levels')
                ->where('id', $schoolId)
                ->with('level_infos')
                ->first();

            if (empty($school)) {
                continue;
            }

            $schoolLevel = $school->level_infos->where('level_id', $registration->basic_details->level_id)
                ->where('school_id', $schoolId)
                ->where('session_year', $applicationCycle->session_year)
                ->first();

            if (empty($schoolLevel)) {
                continue;
            }

            $allottedStudentsCount = \Models\RegistrationCycle::whereHas('application_details', function ($sub_query) use ($applicationCycle) {

                $sub_query->where('session_year', $applicationCycle->session_year);
            })
                ->whereIn('status', ['allotted', 'enrolled'])
                ->where('allotted_school_id', $schoolId)
                ->count();

            // Check for the seats availability
            $available_seats = $schoolLevel->available_seats - $allottedStudentsCount;

            if ($available_seats < 1) {
                continue;
            }

            $allottedStudentsCount += 1;
            $fullhouse = (($schoolLevel->available_seats - $allottedStudentsCount) > 0) ? 'false' : 'true';

            // Update the school stats
            \Models\AllottmentStatistic::updateOrCreate(
                [
                    'school_id' => $school->id,
                    'level_id' => $registration->basic_details->level_id,
                    'year' => $applicationCycle->session_year,
                    'application_cycle_id' => $applicationCycle->id,
                ],
                [
                    'allotted_seats' => $allottedStudentsCount,
                    'full_house' => $fullhouse,
                ]
            );

            // Allot the school to child and break the loop
            \Models\RegistrationCycle::where('registration_id', $registration->registration_id)
                ->where('application_cycle_id', $applicationCycle->id)
                ->update(['status' => 'allotted', 'allotted_school_id' => $schoolId]);

            $isAllotted = true;

            break;
        }

        if ($isAllotted == false) {
            throw new EntityNotFoundException('Unable to allocate the seat');
        }

        $data['reload'] = true;

        return api('Seat allotted successfully.', $data);
    }

    public function getNotAllottedStudents(Request $request)
    {

        $applicationCycle = $this->data['latest_application_cycle'];

        // Get all the students
        $currCycleStudents = \Models\RegistrationCycle::where('application_cycle_id', $this->data['latest_application_cycle']->id)
            ->whereHas('application_details', function ($q) use ($applicationCycle) {
                $q->where('session_year', $applicationCycle['session_year']);
            })
            ->whereHas('basic_details', function ($q) {
                $q->where('status', 'completed');
            })
            ->get()
            ->pluck('registration_id')
            ->toArray();

        // Get the old cycle students
        $oldCycleStudents = \Models\RegistrationCycle::where('status', 'applied')
            ->where('document_verification_status', 'verified')
            ->whereNotIn('registration_id', $currCycleStudents)
            ->where('application_cycle_id', '<', $this->data['latest_application_cycle']->id)
            ->whereHas('application_details', function ($q) use ($applicationCycle) {
                $q->where('session_year', $applicationCycle['session_year']);
            })
            ->whereHas('basic_details', function ($q) {
                $q->where('status', 'completed');
            })
            ->get()
            ->pluck('registration_id')
            ->toArray();

        // $registrations = array_unique(array_merge($currCycleStudents, $oldCycleStudents));

        if (count($oldCycleStudents) <= 0) {
            return api("Students who got no seat", []);
        }

        $studentsData = array();

        foreach ($oldCycleStudents as $key => $registrationId) {

            // Will get the latest registration cycle details
            $student = \Models\RegistrationCycle::where('registration_id', $registrationId)
                ->orderBy('created_at', 'desc')
                ->with(['basic_details.level'])
                ->first();

            if ($student->status !== 'applied' && $student->document_verification_status !== 'verified') {
                continue;
            }

            $schoolsData = array();

            // Merge all the selected schoold
            $selectedSchools = array_merge($student->preferences ? $student->preferences : [], $student->nearby_preferences ? $student->nearby_preferences : []);

            foreach ($selectedSchools as $key => $schoolId) {

                // Get the schools level info
                $school = \Models\School::select('id', 'udise', 'school_type', 'levels', 'application_status', 'status')
                    ->where('id', $schoolId)
                    ->where('application_status', 'verified')
                    ->where('status', 'active')
                    ->with('level_infos')
                    ->first();

                if (empty($school)) {
                    continue;
                }

                if (!(in_array($student->basic_details->level_id, $school->levels))) {
                    continue;
                }

                // get School cycle for the current year
                $schoolcycle = \Models\SchoolCycle::where('school_id', $schoolId)
                    ->whereHas('application_cycle', function ($q) use ($applicationCycle) {
                        $q->where('session_year', $applicationCycle['session_year']);
                    })
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($schoolcycle->status !== 'verified') {
                    continue;
                }

                $schoolLevel = $school->level_infos->where('level_id', $student->basic_details->level_id)
                    ->where('school_id', $schoolId)
                    ->where('session_year', $applicationCycle->session_year)
                    ->first();

                if (empty($schoolLevel)) {
                    continue;
                }

                $allottedStudentsCount = \Models\RegistrationCycle::whereHas('application_details', function ($sub_query) use ($applicationCycle) {
                    $sub_query->where('session_year', $applicationCycle->session_year);
                })
                    ->whereHas('basic_details', function ($q) use ($student) {
                        $q->where('level_id', $student->basic_details->level_id);
                    })
                    ->whereIn('status', ['allotted', 'enrolled'])
                    ->where('allotted_school_id', $schoolId)
                    ->count();

                // Check for the seats availability
                $available_seats = $schoolLevel->available_seats - $allottedStudentsCount;

                if ($available_seats <= 0) {
                    continue;
                }

                $school['total_available_seats'] = $schoolLevel->available_seats;
                $school['total_allotted_students'] = $allottedStudentsCount;
                $school['total_remaining_seats'] = $available_seats;

                array_push($schoolsData, $school);

            }

            if (empty($schoolsData)) {
                continue;
            }

            $student['schools'] = $schoolsData;

            array_push($studentsData, $student);

        }

        return api("Students who got no seat", $studentsData);

    }

    public function getStudentsNotUpdatedSecondCycle(Request $request)
    {

        $applicationCycle = $this->data['latest_application_cycle'];

        if ($applicationCycle->cycle <= 1) {
            throw new EntityNotFoundException('Currently first cycle is ongoing');
        }

        $registrations = \Models\RegistrationBasicDetail::where('state_id', $this->state_id)
            ->orderBy('id', 'asc')
            ->where('status', 'completed')
            ->with(['registration_cycle'])
            ->whereHas('registration_cycle', function ($query) use ($applicationCycle) {
                $query->where('status', 'applied');
                $query->where('document_verification_status', 'verified');
                $query->whereHas('application_details', function ($sub_query) use ($applicationCycle) {
                    $sub_query->where('session_year', $applicationCycle->session_year)
                        ->where('cycle', '<', $applicationCycle->cycle);
                });
            })
            ->whereDoesntHave('registration_cycle', function ($query) use ($applicationCycle) {
                $query->where('application_cycle_id', $applicationCycle->id);
            })->get();

        return api("", $registrations);

    }
}
