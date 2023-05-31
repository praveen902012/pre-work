<?php
namespace Helpers;

class PostLotteryAnalysisHelper {

	public static function studentAllottedInMultipleCycles($app_cyc_id) {
    
        $data=[];

        $app_cyc = \Models\ApplicationCycle::find($app_cyc_id);

        $this_cyc_allotted_students = \Models\RegistrationCycle::where('application_cycle_id', $app_cyc->id)
                                                    ->where('status', '<>', 'applied')
                                                    ->pluck('registration_id');

        if($app_cyc->cycle > 1){

            $data = \Models\RegistrationCycle::whereIn('registration_id', $this_cyc_allotted_students)
                                        ->where('cycle', '<', $app_cyc->cycle)
                                        ->whereIn('status', ['allotted', 'enrolled'])
                                        ->select('cycle','registration_id')
                                        ->get()
                                        ->groupBy('cycle');
        }

        return $data;
    }

    public static function schoolAllotedMoreThanAvailableSeats($app_cyc_id) {
        
        $app_cyc = \Models\ApplicationCycle::find($app_cyc_id);

        $all_allotted_students = \Models\RegistrationCycle::whereHas('application_details', function($query) use($app_cyc){

                                            $query->where('session_year', $app_cyc->session_year);
                                        })
                                        ->where('cycle', '<=', $app_cyc->cycle)
                                        ->whereIn('status', ['allotted', 'enrolled'])
                                        ->get();

        $school_ids = $all_allotted_students->pluck('allotted_school_id')->unique()->values();

        $schools = \Models\School::whereIn('id', $school_ids)->get();

        $school_entry_levels = \Models\SchoolLevelInfo::where('session_year', $app_cyc->session_year)->get();

        $data = [];

        foreach($schools as $school){

            $all_allotted_student_count = $all_allotted_students->where('allotted_school_id', $school->id)->count();

            $e_level = $school_entry_levels->where('school_id', $school->id)->where('level_id', $school->levels[0])->first();

            if($e_level){

                if($all_allotted_student_count > $e_level->available_seats){

                    array_push($data, $school->id);
                }
            }
        }

        return $data;
    }

    public static function schoolSeatsAvaliableStudentNotAllotted($app_cyc_id) {
    
        $app_cyc = \Models\ApplicationCycle::find($app_cyc_id);

        $unallotted_students = \Models\RegistrationCycle::whereHas('application_details', function($query) use($app_cyc){

                            $query->where('session_year', $app_cyc->session_year);
                        })
                        ->where('document_verification_status', 'verified')
                        ->where('application_cycle_id', $app_cyc->id) ## comment this line if you want to know unallotted for entire session
                        ->where('cycle', '<=', $app_cyc->cycle)
                        ->where('status', 'applied')
                        ->with('basic_details')
                        ->get();

        $prf = $unallotted_students->where('preferences', '<>', null)->pluck('preferences')->toArray();

        $nprf = $unallotted_students->where('nearby_preferences', '<>', null)->pluck('nearby_preferences')->toArray();
        
        $prf = call_user_func_array('array_merge', $prf);
        $nprf = call_user_func_array('array_merge', $nprf);

        $school_ids = collect(array_merge($prf, $nprf))->unique()->values();

        $schools = \Models\SchoolCycle::whereHas('application_cycle', function($query) use($app_cyc){

                            $query->where('session_year', $app_cyc->session_year);
                        })
                        ->whereIn('school_id', $school_ids)
                        ->has('school')
                        ->with('school')
                        ->get()
                        ->pluck('school');

        $all_allotted_students = \Models\RegistrationCycle::whereHas('application_details', function($query) use($app_cyc){

                        $query->where('session_year', $app_cyc->session_year);
                    })
                    ->where('cycle', '<=', $app_cyc->cycle)
                    ->whereIn('status', ['allotted', 'enrolled'])
                    ->get();

        $school_entry_levels = \Models\SchoolLevelInfo::where('session_year', $app_cyc->session_year)->get();

        $data = [];

        foreach($schools as $school){

            $all_allotted_student_count = $all_allotted_students->where('allotted_school_id', $school->id)->count();

            $e_level = $school_entry_levels->where('school_id', $school->id)->where('level_id', $school->levels[0])->first();

            if($e_level){

                if($all_allotted_student_count < $e_level->available_seats){

                    array_push($data, $school->id);
                }
            }
        }

        return $data;
    }

}