<?php
namespace Helpers;

class LotteryTriggerWithCycleHelper
{
    protected static $data = [];
    protected static $all_schools = [];
    protected static $all_schools_level_info = [];

    public static function allotSeatsToGirlApplicant($current_lot, $max_iteration, $max_seats_to_be_alloted, $applicationCycle, $pref = 'preferences')
    {

        /**
         * return array $current_lot student whose first peference/nearby_preferences were not checked [Depending on the current $pref value]
         * return array $pending_lot student whose first peference/nearby_preferences were not checked entirely [Depending on the current $pref value]
         *
         * return integer $seats_alloted number of student who were alloted seats
         *
         * return integer $alloted_students student with ids who were alloted seats
         *
         * return array $nearby_lot student who have nearby peference [In case pref is set to preference]
         *
         * @param array $current_lot student applied for admission
         *
         * @param integer $max_iteration max number of school filled as preference by a student
         *
         * @param integer $max_seats_to_be_alloted max number of seats to allot [considering the 50% reservation right to girls]
         *
         * @param collection $applicationCycle application cycle to get the current session year
         *
         * @param string $pref defines whether to check first prefernece or nearby preference filled by a student
         */

        $cnt = true;
        $iteration = 1;
        $pending_lot = [];
        $nearby_lot = [];
        $seats_alloted = 0;
        $alloted_students = [];
        $nearby_lot_id = [];
        $exhausted_id = [];

        while ($iteration <= $max_iteration && $cnt) {

            while (count($current_lot) > 0 && $max_seats_to_be_alloted > $seats_alloted) {

                $selected = rand(0, count($current_lot) - 1);

                \Log::Info("Selected to allot ID - " . $current_lot[$selected]['id']);

                if (sizeof($current_lot[$selected]['registration_cycle'][$pref]) >= $iteration) {

                    $school_id = $current_lot[$selected]['registration_cycle'][$pref][$iteration - 1];

                    $school = self::$all_schools->where('id', $school_id)->first();

                    $allowed_school_type = ['co-educational', 'girls'];

                    \Log::Info("Allotting ID - " . $current_lot[$selected]['id']);

                    if (!empty($school->school_type) && isset($school->school_type) && in_array($school->school_type, $allowed_school_type)) {

                        // CodeReview:select only requied fields this query can be a one time query
                        // instead of quwrying mutiple times

                        $totalSeats = self::$all_schools_level_info->where('school_id', $school_id)
                            ->where('level_id', $current_lot[$selected]['level_id'])
                            ->first();

                        $rt_available_seats = 0;

                        $rt_schools_level = \Models\SchoolLevelInfo::select('id', 'school_id', 'level_id', 'available_seats')
                            ->where('school_id', $school_id)
                            ->whereIn('level_id', $school->levels)
                            ->where('session_year', $applicationCycle->session_year)
                            ->orderBy('id', 'DESC')
                            ->first();

                        $rt_alloted_students = \Models\RegistrationCycle::whereHas('application_details', function ($sub_query) use ($applicationCycle) {

                            $sub_query->where('session_year', $applicationCycle->session_year);
                        })
                            ->whereIn('status', ['allotted', 'enrolled'])
                            ->where('allotted_school_id', $school_id)
                            ->count();

                        if (!empty($rt_schools_level)) {

                            $rt_available_seats = $rt_schools_level->available_seats - $rt_alloted_students;
                        }

                        if ($rt_available_seats > 0 && in_array($current_lot[$selected]['level_id'], $school->levels)) {

                            // Get the registration cycle and update the allotment details

                            $registrationCycle = \Models\RegistrationCycle::where('registration_id', $current_lot[$selected]['id'])
                                ->where('application_cycle_id', '<=', $applicationCycle->id)
                                ->orderBy('created_at', 'desc')
                                ->first();

                            if (!empty($registrationCycle)) {

                                $totalSeats->alloted += 1;
                                $fullhouse = (($totalSeats->available_seats - $totalSeats->alloted) > 0) ? 'false' : 'true';

                                \Models\AllottmentStatistic::updateOrCreate(
                                    [
                                        'school_id' => $school_id,
                                        'level_id' => $current_lot[$selected]['level_id'],
                                        'year' => $applicationCycle->session_year,
                                        'application_cycle_id' => $applicationCycle->id,
                                    ],
                                    [
                                        'allotted_seats' => $totalSeats->alloted,
                                        'full_house' => $fullhouse,
                                    ]
                                );

                                $registrationCycle->status = 'allotted';
                                $registrationCycle->allotted_school_id = $school_id;
                                $registrationCycle->save();

                                $alloted_students[] = $current_lot[$selected]['id'];
                                $seats_alloted++;

                                \Log::Info("Allotted For ID - " . $current_lot[$selected]['id']);

                            } else {

                                \Log::Info("Registration cycle not found for id - " . $current_lot[$selected]['id']);

                            }

                        } else {

                            \Log::Info("Seat not available for ID - " . $current_lot[$selected]['id']);

                            if (sizeof($current_lot[$selected]['registration_cycle'][$pref]) == $iteration) {

                                if ($pref == 'preferences' && (sizeof($current_lot[$selected]['registration_cycle']['nearby_preferences']) > 0)) {
                                    if (in_array($current_lot[$selected]['id'], $nearby_lot_id)) {
                                        //id already exist so do nothing
                                    } else {

                                        array_push($nearby_lot, $current_lot[$selected]);
                                        $nearby_lot_id[] = $current_lot[$selected]['id'];
                                    }

                                } else {
                                    $exhausted_id[] = $current_lot[$selected]['id'];

                                }

                            } else {
                                array_push($pending_lot, $current_lot[$selected]);
                            }

                        }
                        //CodeReview: the below query can have another check if its not full_house
                        //if its full_house the code need not proceed further

                        //CodeReview: the below code allots one extra seat the first time seat is alloted

                    } else {
                        if (sizeof($current_lot[$selected]['registration_cycle'][$pref]) == $iteration) {
                            if ($pref == 'preferences' && (sizeof($current_lot[$selected]['registration_cycle']['nearby_preferences']) > 0)) {
                                if (in_array($current_lot[$selected]['id'], $nearby_lot_id)) {
                                    //id already exist so do nothing
                                } else {

                                    array_push($nearby_lot, $current_lot[$selected]);
                                    $nearby_lot_id[] = $current_lot[$selected]['id'];
                                }

                            } else {
                                $exhausted_id[] = $current_lot[$selected]['id'];

                            }

                        } else {

                            array_push($pending_lot, $current_lot[$selected]);
                        }
                    }
                } else {
                    //CodeReview: implementing the below improvement would improve the runtime
                    //of algorithm

                    if ($pref == 'preferences' && (sizeof($current_lot[$selected]['registration_cycle']['nearby_preferences']) > 0)) {
                        if (in_array($current_lot[$selected]['id'], $nearby_lot_id)) {
                            //id already exist so do nothing
                        } else {

                            array_push($nearby_lot, $current_lot[$selected]);
                            $nearby_lot_id[] = $current_lot[$selected]['id'];
                        }

                    } elseif (!in_array($current_lot[$selected]['id'], $exhausted_id)) {
                        $exhausted_id[] = $current_lot[$selected]['id'];

                    }
                }

                array_splice($current_lot, $selected, 1);

            }

            if (count($pending_lot) > 0 && ($max_seats_to_be_alloted > $seats_alloted)) {

                $current_lot = $pending_lot;
                $pending_lot = [];
                $iteration = $iteration + 1;
            } else {

                $cnt = false;
            }
        }

        return array($current_lot, $pending_lot, $seats_alloted, $alloted_students, $nearby_lot, $nearby_lot_id, $exhausted_id);

    }

    public static function allotSeatsToApplicant($current_lot, $max_iteration, $applicationCycle, $pref = 'preferences')
    {

        $cnt = true;
        $iteration = 1;
        $pending_lot = [];
        $nearby_lot = [];
        $seats_alloted = null;
        $girls_alloted_count = 0;
        $girls_alloted_ids = [];
        $alloted_students = [];
        $nearby_lot_id = [];
        $exhausted_id = [];

        while ($iteration <= $max_iteration && $cnt == true) {

            while (count($current_lot) > 0) {

                $selected = rand(0, count($current_lot) - 1);

                \Log::Info("Selected to allot ID - " . $current_lot[$selected]['id']);

                if (sizeof($current_lot[$selected]['registration_cycle'][$pref]) >= $iteration) {

                    $school_id = $current_lot[$selected]['registration_cycle'][$pref][$iteration - 1];

                    $school = self::$all_schools->where('id', $school_id)->first();

                    $allowed_school_type = [];

                    if ($current_lot[$selected]['gender'] == 'male') {
                        $allowed_school_type = ['co-educational', 'boys'];
                    } elseif ($current_lot[$selected]['gender'] == 'transgender') {
                        $allowed_school_type = ['co-educational'];
                    } elseif ($current_lot[$selected]['gender'] == 'female') {
                        $allowed_school_type = ['co-educational', 'girls'];
                    }

                    \Log::Info("Allotting ID - " . $current_lot[$selected]['id']);

                    if (!empty($school->school_type) && isset($school->school_type) && in_array($school->school_type, $allowed_school_type)) {

                        // CodeReview: select only the required columns in the below two queries

                        $totalSeats = self::$all_schools_level_info->where('school_id', $school_id)
                            ->where('level_id', $current_lot[$selected]['level_id'])
                            ->first();

                        $rt_available_seats = 0;

                        $rt_schools_level = \Models\SchoolLevelInfo::select('id', 'school_id', 'level_id', 'available_seats')
                            ->where('school_id', $school_id)
                            ->whereIn('level_id', $school->levels)
                            ->where('session_year', $applicationCycle->session_year)
                            ->orderBy('id', 'DESC')
                            ->first();

                        $rt_alloted_students = \Models\RegistrationCycle::whereHas('application_details', function ($sub_query) use ($applicationCycle) {

                            $sub_query->where('session_year', $applicationCycle->session_year);
                        })
                            ->whereIn('status', ['allotted', 'enrolled'])
                            ->where('allotted_school_id', $school_id)
                            ->count();

                        if (!empty($rt_schools_level)) {

                            $rt_available_seats = $rt_schools_level->available_seats - $rt_alloted_students;
                        }

                        if ($rt_available_seats > 0 && in_array($current_lot[$selected]['level_id'], $school->levels)) {

                            // Get the registration cycle and update the allotment details

                            $registrationCycle = \Models\RegistrationCycle::where('registration_id', $current_lot[$selected]['id'])
                                ->where('application_cycle_id', '<=', $applicationCycle->id)
                                ->orderBy('created_at', 'desc')
                                ->first();

                            if (!empty($registrationCycle)) {

                                $totalSeats->alloted += 1;
                                $fullhouse = (($totalSeats->available_seats - $totalSeats->alloted) > 0) ? 'false' : 'true';

                                \Models\AllottmentStatistic::updateOrCreate(
                                    [
                                        'school_id' => $school_id,
                                        'level_id' => $current_lot[$selected]['level_id'],
                                        'year' => $applicationCycle->session_year,
                                        'application_cycle_id' => $applicationCycle->id,

                                    ],
                                    [
                                        'allotted_seats' => $totalSeats->alloted,
                                        'full_house' => $fullhouse,
                                    ]
                                );

                                $registrationCycle->status = 'allotted';
                                $registrationCycle->allotted_school_id = $school_id;
                                $registrationCycle->save();

                                $alloted_students[] = $current_lot[$selected]['id'];
                                $seats_alloted++;

                                \Log::Info("Allotted For ID - " . $current_lot[$selected]['id']);

                                if ($current_lot[$selected]['gender'] == 'female') {
                                    $girls_alloted_count += 1;
                                    $girls_alloted_ids[] = $current_lot[$selected]['id'];
                                }

                            } else {
                                \Log::Info("Registration cycle not found for id - " . $current_lot[$selected]['id']);
                            }

                        } else {

                            \Log::Info("Seat not available for ID - " . $current_lot[$selected]['id']);

                            if (sizeof($current_lot[$selected]['registration_cycle'][$pref]) == $iteration) {
                                if ($pref == 'preferences' && (sizeof($current_lot[$selected]['registration_cycle']['nearby_preferences']) > 0)) {
                                    if (in_array($current_lot[$selected], $nearby_lot_id)) {
                                        //do nothing

                                    } else {
                                        array_push($nearby_lot, $current_lot[$selected]);
                                        $nearby_lot_id[] = $current_lot[$selected]['id'];
                                    }

                                } else {
                                    $exhausted_id[] = $current_lot[$selected]['id'];

                                }

                            } else {

                                array_push($pending_lot, $current_lot[$selected]);
                            }

                        }

                    } else {
                        if (sizeof($current_lot[$selected]['registration_cycle'][$pref]) == $iteration) {
                            if ($pref == 'preferences' && (sizeof($current_lot[$selected]['registration_cycle']['nearby_preferences']) > 0)) {
                                if (in_array($current_lot[$selected], $nearby_lot_id)) {
                                    //do nothing

                                } else {
                                    array_push($nearby_lot, $current_lot[$selected]);
                                    $nearby_lot_id[] = $current_lot[$selected]['id'];
                                }

                            } else {
                                $exhausted_id[] = $current_lot[$selected]['id'];

                            }

                        } else {

                            array_push($pending_lot, $current_lot[$selected]);
                        }
                    }
                } else {
                    if ($pref == 'preferences' && (sizeof($current_lot[$selected]['registration_cycle']['nearby_preferences']) > 0)) {
                        if (in_array($current_lot[$selected], $nearby_lot_id)) {
                            //do nothing

                        } else {
                            array_push($nearby_lot, $current_lot[$selected]);
                            $nearby_lot_id[] = $current_lot[$selected]['id'];
                        }

                    } elseif (!in_array($current_lot[$selected]['id'], $exhausted_id)) {
                        $exhausted_id[] = $current_lot[$selected]['id'];

                    }
                }

                //CodeReview: array_push($pending_lot, $current_lot[$selected]); is reapeated four times
                //restructuring the conditions should cut them down

                array_splice($current_lot, $selected, 1);

            }

            if (count($pending_lot) > 0) {

                $current_lot = $pending_lot;
                $pending_lot = [];
                $iteration = $iteration + 1;
            } else {

                $cnt = false;
            }
        }
        return array($current_lot, $pending_lot, $alloted_students, $nearby_lot, $girls_alloted_count, $girls_alloted_ids, $nearby_lot_id, $exhausted_id);

    }

    public static function getMaxPrefSize($applicants, $pref = 'preferences')
    {
        $max_pref = null;

        foreach ($applicants as $applicant) {
            if (isset($applicant['registration_cycle'][$pref])) {

                $pref_size = count($applicant['registration_cycle'][$pref]);
                $max_pref = max($pref_size, $max_pref);
            }
        }
        return $max_pref;
    }

    public static function addAllotmentHistory($state_id, $alloted_student_reg_id, $total_student_reg_id, $message, $year, $metadata)
    {

        \Models\AllotmentHistory::create([
            'state_id' => $state_id,
            'alloted_student_reg_id' => json_encode($alloted_student_reg_id),
            'total_student_reg_id' => json_encode($total_student_reg_id),
            'message' => $message,
            'year' => $year,
            'metadata' => json_encode($metadata),
        ]);

    }

    public static function triggerLottery($state_id, $type = "auto")
    {

        \Log::info("<=================== Lottery Started =========================>");

        //for this particular state check if there is any new application cycle
        //if yes type is manual
        //update the trigger_type
        //loop through each class for which admission is open
        //get all the registered applicant for the state
        //where status is applied
        //along with the registratoin cycle details
        // where the application cycle id is the same as the selected application cycle

        //while iteration is less than max_iteration
        //if count of currenlty processing lot is greater than 0
        //then randomly select one of the applicant
        //and get the school which had been set as the current iteration

        //if there are seats left for the level which the student had selected
        //then allot the seat to the student
        //and take care of other things
        // else
        //place the applicant in the pending lot
        // remove the applicant from the currently processing lot

        //else increment iteration empty contents of pending lot to current lot

        $applicationCycle = \Models\ApplicationCycle::select('id', 'session_year', 'cycle', 'trigger_type', 'status', 'lottery_announcement')
            ->where('state_id', $state_id)
            ->where('status', 'new')
            ->where('is_latest', true)
            ->orderBy('updated_at', 'desc')
            ->first();

        // get class for which admission is open
        $levels = \Models\Level::select("id")
            ->where('entry_point', true)
            ->orderBy('id')
            ->get();

        $priorities = ['p1', 'p2']; // p1 => previoust cycle un-allotted students

        foreach ($priorities as $priority) {

            $previous_allottment_statistics = \Models\RegistrationCycle::whereHas('application_details', function ($sub_query) use ($applicationCycle) {

                $sub_query->where('session_year', $applicationCycle->session_year);
            })
                ->whereIn('status', ['allotted', 'enrolled'])
                ->with('basic_details')
                ->get();

            foreach ($levels as $level) {

                $dynamic_match = '"' . $level->id . '"';

                self::$all_schools = \Models\School::select('id', 'school_type', 'levels')
                    ->where('status', 'active')
                    ->where('application_status', 'verified')
                    ->where('state_id', $state_id)
                    ->whereRaw("levels @> " . "'" . $dynamic_match . "'")
                    ->orderBy('id')
                    ->get();

                $total_schools_in_state = self::$all_schools->pluck('id');

                self::$all_schools_level_info = \Models\SchoolLevelInfo::select('school_id', 'level_id', 'available_seats', 'session_year')
                    ->whereIn('school_id', $total_schools_in_state)
                    ->where('level_id', $level->id)
                    ->where('session_year', $applicationCycle->session_year)
                    ->get();

                // get total seat offered by all school in current state for this class
                $total_seats = 0;

                foreach (self::$all_schools_level_info as $value) {

                    $value['alloted'] = $previous_allottment_statistics
                        ->where('basic_details.level_id', $level->id)
                        ->where('allotted_school_id', $value->school_id)
                        ->count();

                    $current_available_seats = $value['available_seats'] - $value['alloted'];

                    $total_seats = $total_seats + $current_available_seats;
                }

                if (empty($total_seats) or $total_seats <= 0) {
                    continue;
                }

                // STEP1 get all girls who applied for current class under current state anf get the total count of girls
                // from total seats calculate reserved seats for girls
                // get minimum of reserved seats and girl applicant count

                // $student_status = ['enrolled', 'allotted'];

                $registration_ids = \Models\RegistrationCycle::where('application_cycle_id', $applicationCycle->id)
                    ->where('document_verification_status', 'verified')
                    ->where('status', 'applied')
                    ->get()
                    ->pluck('registration_id')
                    ->toArray();

                $all_applicants_query = \Models\RegistrationBasicDetail::select('id', 'level_id', 'gender')
                    ->whereIn('id', $registration_ids) # uncomment to boost up speed
                    ->where('state_id', $state_id)
                    ->where('level_id', $level->id)
                    ->where('status', 'completed')
                    ->with(['registration_cycle']);

                if ($priority == 'p1') {

                    $previous_unallotted_students = \Models\RegistrationCycle::whereHas('application_details', function ($sub_query) use ($applicationCycle) {

                        $sub_query->where('session_year', $applicationCycle->session_year)
                            ->where('cycle', '<', $applicationCycle->cycle);
                    })
                        ->where('status', 'applied')
                        ->where('document_verification_status', 'verified')
                        ->where('cycle', '<', $applicationCycle->cycle)
                        ->get()
                        ->pluck('registration_id');

                    if (!empty($previous_unallotted_students)) {

                        // Get all the students who doesn't have entry for second cyle or updated for second cycle,
                        // Completed and verified for the first cycle

                        $all_applicants_query = \Models\RegistrationBasicDetail::select('id', 'level_id', 'gender')
                            ->whereIn('id', $previous_unallotted_students) # uncomment to boost up speed
                            ->whereNotIn('id', $registration_ids) # Current cycle registrations
                            ->where('state_id', $state_id)
                            ->where('level_id', $level->id)
                            ->where('status', 'completed')
                            ->with(['registration_cycle']);
                    }
                }

                $all_applicants = $all_applicants_query->get();

                $all_applicants = $all_applicants->where('registration_cycle.document_verification_status', 'verified') # delete to boost up speed
                    ->where('registration_cycle.status', 'applied') # delete to boost up speed
                    ->values(); # delete to boost up speed

                $girl_applicants = $all_applicants->where('gender', 'female');

                $girl_applicants_ids = $girl_applicants->pluck('id')->toArray();

                $girl_applicants = array_merge($girl_applicants->toArray(), []);

                // Suppose situtaion where s1 has filled 5 preferences and s2 has filled only 2 preferences
                // while alloting we need to check all the preferences of student hence taking the max_preference

                $max_preference_girl = self::getMaxPrefSize($girl_applicants);

                $girl_applicants_count = count($girl_applicants);

                $reserved_seat = intval(ceil(($total_seats / 2)));

                // for situtaion where the number of girls who applied for current class is less than the reserved seat
                // we follow the below rule

                $max_seats_to_be_alloted = min($girl_applicants_count, $reserved_seat);

                // start allotment for girls

                $ret_val_girl = self::allotSeatsToGirlApplicant($girl_applicants, $max_preference_girl, $max_seats_to_be_alloted, $applicationCycle);

                $metadata = array(
                    'level_id' => $level->id,
                    'lottery_id' => $applicationCycle->id,
                    'lottery_cycle' => $applicationCycle->cycle,
                );

                self::addAllotmentHistory($state_id, $ret_val_girl[3], $girl_applicants_ids, 'Step1 allotment process for girls reserved seats', $applicationCycle->session_year, $metadata);

                // girl applicant's ID who didn't get any seat except nearby_lot and who have exhausted their preference
                $girl_applicants_ids_diff = array_values(array_diff($girl_applicants_ids, $ret_val_girl[3], $ret_val_girl[5], $ret_val_girl[6]));

                //STEP2 get all boys and trans applicant who applied for current class under current state

                // CodeReview: getting applicants can be made into one query
                // then we can get girl applicant using collection
                // thereby avoiding another query with the database

                // CodeReview: is there need for a sub query here
                // cant we just do where gender is not girl

                $boy_trans_applicants = $all_applicants->where('gender', '<>', 'female');

                $boy_trans_applicants_ids = $boy_trans_applicants->pluck('id')->toArray();

                $boy_trans_applicants = array_merge($boy_trans_applicants->toArray(), []);

                $rest_applicants = array_merge($boy_trans_applicants, $ret_val_girl[0], $ret_val_girl[1]);

                //CodeReview the max_preference_girl needs to be updated

                $max_preference_rest = self::getMaxPrefSize($rest_applicants);

                $ret_val_rest = self::allotSeatsToApplicant($rest_applicants, $max_preference_rest, $applicationCycle);

                $rest_applicants_ids = array_merge($boy_trans_applicants_ids, $girl_applicants_ids_diff);

                self::addAllotmentHistory($state_id, $ret_val_rest[2], $rest_applicants_ids, 'Step2 allotment process for boys, girls and trans applicants', $applicationCycle->session_year, $metadata);

                // ids without nearby_lot_ids and exhuasted applicants
                $rest_applicants_ids_diff = array_values(array_diff($rest_applicants_ids, $ret_val_rest[2], $ret_val_rest[6], $ret_val_rest[7]));

                //     // CodeReview: if girls are left we can just add them to the pending lot
                //     // we need not call allotSeatsToApplicant for both if and else conditions
                // STEP3 allotment on the basis of nearby_preferences
                // if reservations clause is sastisfied mix unalloted girls with boys and trans

                $check_girl_reservation = ($max_seats_to_be_alloted - ($ret_val_girl[2] + $ret_val_rest[4])) > 0 ? false : true;

                if ($check_girl_reservation) {

                    $unallocated_applicants = array_merge($ret_val_girl[4], $ret_val_rest[3]);

                    $max_near_preference_unallocated = self::getMaxPrefSize($unallocated_applicants, 'nearby_preferences');

                    $ret_val_unallocated = self::allotSeatsToApplicant($unallocated_applicants, $max_near_preference_unallocated, $applicationCycle, 'nearby_preferences');

                    $rest_applicants_with_nearby_lot = array_merge($rest_applicants_ids_diff, $ret_val_rest[6], $ret_val_girl[5]);

                    self::addAllotmentHistory($state_id, $ret_val_unallocated[2], $rest_applicants_with_nearby_lot, 'Step3 allotment process for boys, girls and trans applicants', $applicationCycle->session_year, $metadata);

                    //with nearby ids
                    $rest_applicants_ids_diff_2 = array_values(array_diff($rest_applicants_with_nearby_lot, $ret_val_unallocated[2], $ret_val_unallocated[7]));

                } else {
                    // CodeReview: if girls are left from first lot fo allotment
                    // then they can be just added to the pending lot
                    // code need not be repeated for both if and else conditions

                    // if reservations clause is not sastisfied
                    // During allotment give priority to girls and allot the girls until unalloted reserved seats are used or their nearby_pref is exhausted
                    // if unalloted reserved seats are used then mix the girls with boys and trans
                    // and start the last allotment process for current class under current state

                    $unallocated_girl_applicants = $ret_val_girl[4];

                    $unallocated_reserved_seat = $max_seats_to_be_alloted - ($ret_val_girl[2] + $ret_val_rest[4]);

                    $max_near_preference_unallocated_girl = self::getMaxPrefSize($unallocated_girl_applicants, 'nearby_preferences');

                    $ret_val_unallocated_girls = self::allotSeatsToGirlApplicant($unallocated_girl_applicants, $max_near_preference_unallocated_girl, $unallocated_reserved_seat, $applicationCycle, 'nearby_preferences');

                    //with nearby_lot ids
                    $total_girls_considered = array_values(array_diff(array_merge($girl_applicants_ids_diff, $ret_val_girl[5]), $ret_val_rest[5]));

                    self::addAllotmentHistory($state_id, $ret_val_unallocated_girls[3], $total_girls_considered, 'Step3 allotment process for girls applicant', $applicationCycle->session_year, $metadata);

                    //without exhausted ids
                    $girl_applicants_ids_diff_2 = array_values(array_diff($total_girls_considered, $ret_val_unallocated_girls[3], $ret_val_unallocated_girls[6]));

                    $last_chance_unallocated_applicants = array_merge($ret_val_unallocated_girls[0], $ret_val_unallocated_girls[1], $ret_val_rest[3]);

                    $max_near_preference_unallocated_last = self::getMaxPrefSize($last_chance_unallocated_applicants, 'nearby_preferences');

                    $ret_val_unallocated_last = self::allotSeatsToApplicant($last_chance_unallocated_applicants, $max_near_preference_unallocated_last, $applicationCycle, 'nearby_preferences');

                    $ret_val_unallocated_last_id = array_merge($rest_applicants_ids_diff, $ret_val_rest[6], $girl_applicants_ids_diff_2);

                    self::addAllotmentHistory($state_id, $ret_val_unallocated_last[2], $ret_val_unallocated_last_id, 'Step3 allotment process for girls, boys and trans applicant', $applicationCycle->session_year, $metadata);
                }

            }

        }

        \Log::info("<========================== Lottery completed successfully ============================>");

        if (count($applicationCycle) > 0) {

            if ($type == 'manual') {
                $applicationCycle->trigger_type = $type;
            }

            $applicationCycle->status = 'completed';
            $applicationCycle->lottery_announcement = \Carbon::now();
            $applicationCycle->save();

        }

    }

}
