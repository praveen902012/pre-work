<?php

namespace Redlof\State\Controllers;

use Illuminate\Http\Request;
use Models\State;
use Redlof\Core\Controllers\Controller;

class StateBaseController extends Controller
{

    protected $state;
    protected $data;

    public function __construct()
    {

        $parameters = \Route::current()->parameters();

        $this->state = State::select('id', 'name', 'slug', 'logo')->where('slug', $parameters['state'])->first();

        // if the sate is not found - redirect to the State not resgitered page
        if (empty($this->state)) {

            // TODO: Create an exception & throw the same
            abort(404);
        }

        $today = \Carbon::now();

        $this->state->school_registration = false;
        $this->state->student_registration = false;

        $school_registration_check = \Models\ApplicationCycle::select('id', 'cycle')
            ->where('state_id', $this->state->id)
            ->where('status', 'new')
            ->whereDate('reg_start_date', '<=', $today)
            ->whereDate('reg_end_date', '>=', $today)
            ->orderBy('updated_at', 'desc')
            ->first();

        $this->state->application_cycle = $school_registration_check;

        if (count($school_registration_check) > 0) {
            $this->state->school_registration = true;
        }

        $stu_registration_check = \Models\ApplicationCycle::select('id', 'cycle')
            ->where('state_id', $this->state->id)
            ->where('status', 'new')
            ->whereDate('stu_reg_start_date', '<=', $today)
            ->whereDate('stu_reg_end_date', '>=', $today)
            ->orderBy('updated_at', 'desc')
            ->first();

        if (count($stu_registration_check) > 0) {
            $this->state->student_registration = true;
        }

        $this->data['students'] = 0;
        $this->data['schools'] = 0;
        $this->data['registered_schools'] = 0;
        $this->data['rejected_schools'] = 0;
        $this->data['banned_schools'] = 0;
        $this->data['verified_student'] = 0;
        $this->data['latest_application_cycle'] = \Helpers\ApplicationCycleHelper::getLatestCycle();

        //New changes for the retrieval of data.

        //Get the latest application cycle.

        //Get the statistics for this application cycle.

        // footer stats starts

        $current_year = $this->data['latest_application_cycle']->session_year;

        $current_year_application_cycle_ids = \Models\ApplicationCycle::where('session_year', $current_year)
            ->pluck('id')
            ->toArray();

        if (!empty($current_year_application_cycle_ids)) {

            // school stats

            // $schoolIds = \Models\SchoolCycle::whereIn('application_cycle_id', $current_year_application_cycle_ids)
            //     ->pluck('school_id');

            // $registered_schools = \Models\School::whereIn('id', $schoolIds)
            //     ->where('state_id', $this->state->id)->where('application_status', '!=', 'applied')
            //     ->count();

            // $rejected_schools = \Models\School::whereIn('id', $schoolIds)
            //     ->where('state_id', $this->state->id)->where('application_status', 'rejected')
            //     ->count();

            // $verified_schools = \Models\School::whereIn('id', $schoolIds)
            //     ->where('status', 'active')
            //     ->where('state_id', $this->state->id)->where('application_status', 'verified')
            //     ->count();

            // // students stats

            // $studentIDs = \Models\RegistrationCycle::whereIn('application_cycle_id', $current_year_application_cycle_ids)
            //     ->pluck('registration_id');

            // $registered_students = \Models\RegistrationBasicDetail::whereIn('id', $studentIDs)
            //     ->where('state_id', $this->state->id)
            //     ->where('status', 'completed')
            //     ->count();

            // $studentIDs = \Models\RegistrationCycle::whereIn('application_cycle_id', $current_year_application_cycle_ids)
            //     ->where('document_verification_status', 'verified')
            //     ->pluck('registration_id');

            // $verified_students = \Models\RegistrationBasicDetail::whereIn('id', $studentIDs)
            //     ->where('state_id', $this->state->id)
            //     ->where('status', 'completed')
            //     ->count();

            // $studentIDs = \Models\RegistrationCycle::whereIn('application_cycle_id', $current_year_application_cycle_ids)
            //     ->where('document_verification_status', 'rejected')
            //     ->pluck('registration_id');

            // $rejected_students = \Models\RegistrationBasicDetail::whereIn('id', $studentIDs)
            //     ->where('state_id', $this->state->id)
            //     ->where('status', 'completed')
            //     ->count();

            // $students_selected_in_lottery = \Models\RegistrationCycle::whereIn('registration_id', $this->getStudentIdsBySession($current_year)['registration_id'])
            //     ->whereIn('status', ['allotted', 'enrolled', 'dismissed'])
            //     ->whereIn('document_verification_status', ['verified'])
            //     ->whereHas('basic_details', function ($sub_query) {

            //         $sub_query->where('state_id', $this->state->id)
            //             ->where('status', 'completed');
            //     })->count();

            // $studentIDs = \Models\RegistrationCycle::whereIn('application_cycle_id', $current_year_application_cycle_ids)
            //     ->where('status', 'enrolled')
            //     ->pluck('registration_id');

            // $school_enrolled_students = \Models\RegistrationBasicDetail::whereIn('id', $studentIDs)
            //     ->where('state_id', $this->state->id)
            //     ->where('status', 'completed')
            //     ->count();

            // $this->data['current_year_registered_schools'] = $registered_schools;
            // $this->data['current_year_rejected_schools'] = $rejected_schools;
            // $this->data['current_year_verified_schools'] = $verified_schools;

            // $this->data['current_year_registered_students'] = $registered_students;
            // $this->data['current_year_verified_students'] = $verified_students;
            // $this->data['current_year_rejected_students'] = $rejected_students;
            // $this->data['students_selected_in_lottery'] = $students_selected_in_lottery;
            // $this->data['school_enrolled_students'] = $school_enrolled_students;

            $this->data['current_year_registered_schools'] = 0;
            $this->data['current_year_rejected_schools'] = 0;
            $this->data['current_year_verified_schools'] = 0;

            $this->data['current_year_registered_students'] = 0;
            $this->data['current_year_verified_students'] = 0;
            $this->data['current_year_rejected_students'] = 0;
            $this->data['students_selected_in_lottery'] = 0;
            $this->data['school_enrolled_students'] = 0;

        }

        // footer stats ends

        $application_cycle = \Helpers\ApplicationCycleHelper::getLatestCycle();

        if (!empty($application_cycle)) {

            $schoolIds = \Models\SchoolCycle::where('application_cycle_id', $application_cycle->id)
                ->pluck('school_id');

            $registered_schools = \Models\School::whereIn('id', $schoolIds)
                ->where('state_id', $this->state->id)->where('application_status', '!=', 'applied')
                ->count();

            $rejected_schools = \Models\School::whereIn('id', $schoolIds)
                ->where('state_id', $this->state->id)->where('application_status', 'rejected')
                ->count();

            $banned_schools = \Models\School::whereIn('id', $schoolIds)
                ->where('state_id', $this->state->id)
                ->where(function ($query) {
                    $query->where('status', 'ban')
                        ->orWhere('status', 'banned');
                })
                ->count();

            $schools = \Models\School::whereIn('id', $schoolIds)
                ->where('status', 'active')
                ->where('state_id', $this->state->id)->where('application_status', 'verified')
                ->count();

            //Now let's get all students belonging to this application cycle.

            $studentIDs = \Models\RegistrationCycle::whereHas('application_details', function ($query) use ($application_cycle) {

                $query->where('session_year', $application_cycle->session_year);
            })
                ->pluck('registration_id');

            $students = \Models\RegistrationBasicDetail::whereIn('id', $studentIDs)
                ->where('state_id', $this->state->id)
                ->where('status', 'completed')
                ->count();

            $studentIDs = \Models\RegistrationCycle::whereHas('application_details', function ($query) use ($application_cycle) {

                $query->where('session_year', $application_cycle->session_year);
            })
                ->where('document_verification_status', 'verified')
                ->pluck('registration_id');

            $verified_students = \Models\RegistrationBasicDetail::whereIn('id', $studentIDs)
                ->where('state_id', $this->state->id)
                ->where('status', 'completed')
                ->count();

            $studentIDs = \Models\RegistrationCycle::whereHas('application_details', function ($query) use ($application_cycle) {

                $query->where('session_year', $application_cycle->session_year);
            })
                ->where('document_verification_status', 'rejected')
                ->pluck('registration_id');

            $rejected_students = \Models\RegistrationBasicDetail::whereIn('id', $studentIDs)
                ->where('state_id', $this->state->id)
                ->where('status', 'completed')
                ->count();

            $this->data['all_application_cycle'] = \Helpers\ApplicationCycleHelper::getAllCycle();

            $this->data['students'] = $students;

            $this->data['rejected_students'] = $rejected_students;

            $this->data['schools'] = $schools;

            $this->data['registered_schools'] = $registered_schools;

            $this->data['rejected_schools'] = $rejected_schools;

            $this->data['banned_schools'] = $banned_schools;

            $this->data['verified_student'] = $verified_students;

        }

        $this->data['state'] = $this->state;
    }

    public function postLanguageChange(Request $request)
    {
        $apiData['reload'] = true;

        return api('Successfully set your prefered language', $apiData)->cookie('lang', $request->lang, 525600, '/');
    }

    private function getStudentIdsBySession($current_year)
    {

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
}
