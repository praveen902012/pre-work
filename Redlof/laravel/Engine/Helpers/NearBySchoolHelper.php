<?php
namespace Helpers;

class NearBySchoolHelper
{

    public static function getNearBySchool($request, $state, $latest_application_cycle)
    {
        $registration_no = $request->registration_no;

        if (empty($registration_no)) {
            $registration_no = $request['registration_no'];
        }

        $registration = \Models\RegistrationPersonalDetail::select('id', 'sub_locality_id', 'locality_id', 'block_id', 'district_id', 'sub_sub_locality_id', 'registration_id')
            ->with(['basic_details'])
            ->whereHas('basic_details', function ($query) use ($registration_no) {
                $query->where('registration_no', $registration_no);
            })->first();

        $applicationCycle = $latest_application_cycle;

        $school_type = 'co-educational';

        if ($registration->basic_details->gender == 'male') {

            $school_type = 'girls';
        } elseif ($registration->basic_details->gender == 'female') {

            $school_type = 'boys';
        }

        $dynamic_match_level = '["' . $registration['basic_details']['level_id'] . '"]';

        $schoolIds = \Models\SchoolCycle::whereHas('application_cycle', function ($s_query) use ($applicationCycle) {

            $s_query->where('session_year', $applicationCycle->session_year);
        })
            ->pluck('school_id')
            ->unique()
            ->values()
            ->toArray();

        if (empty($request->distance)) {
            $distance = '0-1';
        } else {
            $distance = $request->distance;
        }

        $schools = \Models\School::where('state_id', $state->id)
            ->where('application_status', 'verified')
            ->where('school_type', '<>', $school_type)
            ->whereIn('id', function ($subQuery) use ($request, $registration, $distance) {

                $dynamic_match = '["' . $registration->locality_id . '"]';

                $subQuery = $subQuery->select('school_id')
                    ->where('range', $distance)
                    ->whereRaw("regions @> " . "'" . $dynamic_match . "'")
                    ->from(with(new \Models\SchoolRange)->getTable());
            })
            ->whereRaw("levels @> " . "'" . $dynamic_match_level . "'")
            ->select('id', 'name', 'address', 'levels')
            ->with(['level_infos', 'total_seats_allotted.application_details'])
            ->get();

        $seats_exausted_school_ids = [];

        foreach ($schools as $school) {

            $school_entry_level = $school->level_infos->where('level_id', $school->levels[0])->where('session_year', $applicationCycle->session_year)->first();

            if (empty($school_entry_level) || !in_array($school->id, $schoolIds)) {

                array_push($seats_exausted_school_ids, $school->id);
                continue;
            }

            $total_seats_allotted = $school->total_seats_allotted;

            if (!empty($total_seats_allotted)) {

                $school_alloted_seats = $total_seats_allotted->where('application_details.session_year', $applicationCycle->session_year)->count();

                if ($school_alloted_seats >= $school_entry_level->available_seats) {

                    array_push($seats_exausted_school_ids, $school->id);
                }

                $school->total_seats_available = $school_entry_level->available_seats - $school_alloted_seats;
            }
        }

        return $schools = $schools->whereNotIn('id', $seats_exausted_school_ids)->values();

    }

}
