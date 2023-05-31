<?php

namespace Redlof\RoleStateAdmin\Controllers\Reports;

use Exceptions\EntityNotFoundException;
use Illuminate\Http\Request;
use Models\State;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class ReportController extends RoleStateAdminBaseController
{
    private function getStudentIdsBySession($request)
    {
        $current_year = $this->data['latest_application_cycle']['session_year'];

        if (!empty($request->year) && $request->year != 'null') {

            $current_year = $request->year;
        }

        $students = \Models\RegistrationCycle::whereHas('application_details', function ($query) use ($current_year) {

            $query->where('session_year', $current_year);
        })->get();

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
    public function getSessionYearStats(Request $request)
    {

        $studentIDs = $this->getStudentIdsBySession($request);

        $data = [];

        // Get all the students who are registered for the current year
        $students = \Models\RegistrationCycle::whereIn('registration_id', $studentIDs['registration_id'])
            ->whereHas('basic_details', function ($query) {
                $query->where('state_id', $this->state->id);
                $query->where('status', 'completed');
            });

        $otherQuery = clone $students;
        $total_registered = $students->count();

        // Girls stats
        $total_registered_girls = $students->whereHas('basic_details', function ($query) {$query->where('gender', 'female');})->get();
        $total_allotted_girls = $total_registered_girls->whereIn('status', ['allotted', 'enrolled', 'dismissed', 'withdraw', 'dropout'])->count();
        $total_enrolled_girls = $total_registered_girls->whereIn('status', ['enrolled'])->count();
        $total_dismissed_girls = $total_registered_girls->whereIn('status', ['dismissed'])->count();
        $total_registered_girls = $total_registered_girls->unique('registration_id')->count();

        // Boys stats
        $total_registered_boys = $otherQuery->whereHas('basic_details', function ($query) {$query->where('gender', '<>', 'female');})->get();

        $total_allotted_boys = $total_registered_boys->whereIn('status', ['allotted', 'enrolled', 'dismissed', 'withdraw', 'dropout'])->count();
        $total_enrolled_boys = $total_registered_boys->whereIn('status', ['enrolled'])->count();
        $total_dismissed_boys = $total_registered_boys->whereIn('status', ['dismissed'])->count();
        $total_registered_boys = $total_registered_boys->unique('registration_id')->count();

        $data = [
            'total_registered' => $total_registered,
            'total_registered_girls' => $total_registered_girls,
            'total_allotted_girls' => $total_allotted_girls,
            'total_enrolled_girls' => $total_enrolled_girls,
            'total_dismissed_girls' => $total_dismissed_girls,
            'total_registered_boys' => $total_registered_boys,
            'total_allotted_boys' => $total_allotted_boys,
            'total_enrolled_boys' => $total_enrolled_boys,
            'total_dismissed_boys' => $total_dismissed_boys,
        ];

        return api('', $data);
    }

    public function getDownoadReports()
    {
        $year = date("Y");

        $application_cycle_ids = \Models\ApplicationCycle::where('session_year', $year)
            ->pluck('id')
            ->toArray();

        if (empty($application_cycle_ids)) {
            throw new EntityNotFoundException('Application cycle not found');
        }

        $school_ids = \Models\SchoolCycle::whereIn('application_cycle_id', $application_cycle_ids)
            ->where('status', 'verified')
            ->pluck('school_id')
            ->toArray();

        $items = [];

        foreach ($school_ids as $school_id) {

            $school = \Models\School::where('id', $school_id)->with(['block', 'district'])->first();

            $school_level_details = \Models\SchoolLevelInfo::where('school_id', $school_id)
                ->where('level_id', $school['levels'][0])
                ->where('session_year', $year)
                ->first();

            if (empty($school_level_details)) {
                continue;
            }

            $total_seats = $school_level_details['available_seats'];

            $first_cycle_allotted_seats = \Models\RegistrationCycle::whereIn('application_cycle_id', $application_cycle_ids)
                ->where('allotted_school_id', $school_id)
                ->where('cycle', 1)
                ->whereIn('status', ['allotted', 'enrolled'])
                ->count();

            $second_cycle_allotted_seats = \Models\RegistrationCycle::whereIn('application_cycle_id', $application_cycle_ids)
                ->where('allotted_school_id', $school_id)
                ->where('cycle', 2)
                ->whereIn('status', ['allotted', 'enrolled'])
                ->count();

            $level = \Models\Level::select('id', 'level')
                ->where('id', $school['levels'][0])
                ->first();

            $InnData['UDISE'] = $school->udise;
            $InnData['School Name'] = $school->name;
            $InnData['Block'] = $school['block'] ? $school['block']->name : 'NA';
            $InnData['District'] = $school['district'] ? $school['district']->name : 'NA';
            $InnData['Class'] = $level['level'];
            $InnData['Total seats'] = $total_seats;
            $InnData['1st cycle allotted seats'] = $first_cycle_allotted_seats ? $first_cycle_allotted_seats : '0';
            $InnData['2nd cycle allotted seats'] = $second_cycle_allotted_seats ? $second_cycle_allotted_seats : '0';

            $items[] = $InnData;

        }

        $reports = \Excel::create('school-reports', function ($excel) use ($items) {

            $excel->sheet('Report List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });
        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'school-reports.xlsx', 'data' => asset('temp/school-reports.xlsx')], 200);

    }

}
