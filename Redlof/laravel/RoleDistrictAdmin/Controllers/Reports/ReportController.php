<?php

namespace Redlof\RoleDistrictAdmin\Controllers\Reports;

use Exceptions\EntityNotFoundException;
use Illuminate\Http\Request;
use Redlof\RoleDistrictAdmin\Controllers\Role\RoleDistrictAdminBaseController;

class ReportController extends RoleDistrictAdminBaseController
{

    public function getSessionYearStats(Request $request)
    {

        $applicationCycle = $this->data['latest_application_cycle'];

        if ($request->year) {

            $applicationCycle = \Models\ApplicationCycle::where('session_year', $request->year)->first();

            if (empty($applicationCycle)) {
                throw new EntityNotFoundException('Application cycle not found');
            }
        }

        $data = [];

        // Get all the students who are registered for the current year
        $students = \Models\RegistrationCycle::whereHas('application_details', function ($query) use ($applicationCycle) {
            $query->where('session_year', $applicationCycle->session_year);
        })
            ->whereHas('basic_details', function ($query) {
                $query->where('state_id', $this->state_id);
                $query->where('status', 'completed');
            })
            ->whereHas('basic_details.personal_details', function ($query) {
                $query->where('district_id', $this->district->id);
            });

        $boysQuery = clone $students;
        $total_registered = $students->count();

        // Girls stats
        $total_registered_girls = $students->whereHas('basic_details', function ($query) {$query->where('gender', 'female');})->get();
        $total_allotted_girls = $total_registered_girls->whereIn('status', ['allotted', 'enrolled', 'dismissed'])->count();
        $total_enrolled_girls = $total_registered_girls->whereIn('status', ['enrolled'])->count();
        $total_dismissed_girls = $total_registered_girls->whereIn('status', ['dismissed'])->count();
        $total_registered_girls = $total_registered_girls->count();

        // Boys stats
        $total_registered_boys = $boysQuery->whereHas('basic_details', function ($query) {$query->where('gender', 'male');})->get();
        $total_allotted_boys = $total_registered_boys->whereIn('status', ['allotted', 'enrolled', 'dismissed'])->count();
        $total_enrolled_boys = $total_registered_boys->whereIn('status', ['enrolled'])->count();
        $total_dismissed_boys = $total_registered_boys->whereIn('status', ['dismissed'])->count();
        $total_registered_boys = $total_registered_boys->count();

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

}
