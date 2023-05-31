<?php

namespace Helpers;

use Models\RegistrationBasicDetail;
use Models\RegistrationCycle;
use Models\School;
use Models\SchoolLevelInfo;
use Models\SchoolNodal;

class DashboardStudentHelper
{

    public static function applyStudentFilter($state_id, $data)
    {
        $filtered_data = [];

        $filtered_data['total_unique_applications_received'] = self::getUniqueApplications($state_id, $data);

        $filtered_data['total_admitted'] = self::getTotalAdmitted($state_id, $data);

        $filtered_data['total_allotted'] = self::getTotalAllotted($state_id, $data);

        $filtered_data['total_rejected'] = self::getTotalRejected($state_id, $data);

        $filtered_data['total_verified'] = self::getTotalVerified($state_id, $data);

        $filtered_data['total_seats'] = self::getTotalSeats($state_id, $data);

        $filtered_data['students_applied_for_diff_cycles'] = self::studentAppliedForDiffCycles($state_id, $data);

        $filtered_data['registered_students_group_graph'] = self::getGroupGraphData($state_id, $data);

        $filtered_data['ews_vs_dg'] = [];

        if ($filtered_data['registered_students_group_graph']['show']) {
            $filtered_data['ews_vs_dg'] = array(
                array(
                    'label' => 'EWS',
                    'value' => $filtered_data['registered_students_group_graph']['ews'],
                ),
                array(
                    'label' => 'DG',
                    'value' => $filtered_data['registered_students_group_graph']['dg'],
                ),
            );
        }

        $filtered_data['registered_students_gender_graph'] = self::getGenderGraphData($state_id, $data);

        $filtered_data['boys_vs_girls'] = [];

        if ($filtered_data['registered_students_gender_graph']['show']) {
            $filtered_data['boys_vs_girls'] = array(
                array(
                    'label' => 'Boys',
                    'value' => $filtered_data['registered_students_gender_graph']['boys'],
                ),
                array(
                    'label' => 'Girls',
                    'value' => $filtered_data['registered_students_gender_graph']['girls'],
                ),
                array(
                    'label' => 'Transgender',
                    'value' => $filtered_data['registered_students_gender_graph']['transgender'],
                ),
            );
        }

        return $filtered_data;
    }

    public static function studentAppliedForDiffCycles($state_id, $data)
    {
        if ($data['selectedCycle'] == 'null') {

            $data['selectedCycle'] = \Helpers\ApplicationCycleHelper::getLatestCycle()->session_year;
        }

        $students = RegistrationBasicDetail::select('id', 'gender')
            ->where('status', 'completed')
            ->where('state_id', $state_id);

        if ($data['selectedDistrict'] != 'null') {

            $students->whereHas('personal_details', function ($query) use ($data) {

                $query->where('district_id', $data['selectedDistrict']);
            });
        }

        if ($data['selectedSex'] != 'null') {

            $students->where('gender', $data['selectedSex']);
        }

        if ($data['selectedCategory'] != 'null') {

            if ($data['selectedCategory'] == 'bpl') {

                $students->whereHas('personal_details', function ($query) use ($data) {

                    $query->where('category', 'bpl');
                });
            } else {

                $students->whereHas('personal_details', function ($query) use ($data) {

                    $query->where('category', 'dg')
                        ->whereRaw("certificate_details->>'dg_type' = '" . $data['selectedCategory'] . "'");
                });
            }
        }

        if ($data['selectedNodal'] != 'null') {

            $all_students = \Models\RegistrationCycle::whereHas('application_details', function ($query) use ($data) {

                $query->where('session_year', $data['selectedCycle']);
            })
                ->whereHas('basic_details', function ($query) {

                    $query->where('status', 'completed');
                })
                ->get();

            $reg_cyc_ids = self::getStudentIds($all_students, $data['selectedNodal']);

            $student_counter = count($reg_cyc_ids);

            return $student_counter;
        }

        if ($data['selectedSchool'] != 'null') {

            $students->whereHas('registration_cycle', function ($query) use ($data) {

                $query->where('allotted_school_id', $data['selectedSchool']);
            });
        }

        $student_ids = $students->get()->pluck('id');

        $all_app_cyc_for_years = \Helpers\ApplicationCycleHelper::getApplicationCycle($data['selectedCycle']);

        foreach ($all_app_cyc_for_years as $app_cyc) {

            $app_cyc->applied_students = \Models\RegistrationCycle::whereIn('registration_id', $student_ids)
                ->where('application_cycle_id', $app_cyc->id)
                ->get();
        }

        return $all_app_cyc_for_years;
    }

    public static function getTotalSeats($state_id, $data)
    {
        if ($data['selectedCycle'] == 'null') {

            $data['selectedCycle'] = \Helpers\ApplicationCycleHelper::getLatestCycle()->session_year;
        }

        $schools = School::select('id', 'udise', 'updated_at', 'district_id', 'school_type', 'levels')
            ->where('state_id', $state_id)
            ->where('application_status', 'verified')
            ->whereHas('schoolcycle.application_cycle', function ($query) use ($data) {

                $query->where('session_year', $data['selectedCycle']);
            })
            ->withCount('schoolcycle');

        if ($data['selectedDistrict'] != 'null') {

            $schools->where('district_id', $data['selectedDistrict']);
        }

        if ($data['selectedNodal'] != 'null') {

            $nodal_school_ids = SchoolNodal::select('id', 'school_id')
                ->where('nodal_id', $data['selectedNodal'])->get()->pluck('school_id');

            $schools->whereIn('id', $nodal_school_ids);
        }

        if ($data['selectedSchool'] != 'null') {

            $schools->where('id', $data['selectedSchool']);

            if ($data['selectedSex'] != 'null') {

                $type = self::getCategoryType($data['selectedSex']);

                $schools->where('school_type', $type);
            }
        }

        $schools = $schools->get()
            ->transform(function ($item, $key) use ($data) {

                if ($item['schoolcycle_count'] > 0) {

                    $total_seats = \Models\SchoolLevelInfo::where('school_id', $item['id'])
                        ->where('session_year', $data['selectedCycle'])
                        ->where('level_id', $item['levels'][0])
                        ->first();

                    if ($total_seats) {

                        $item['available_seats'] = $total_seats->available_seats;

                        return $item;
                    }
                }
            })
            ->filter();

        $total_seats = $schools->sum('available_seats');

        return $total_seats;
    }

    public static function getUniqueApplications($state_id, $data)
    {
        $studentIDs = self::getStudentIdsBySession($data);

        $students = \Models\RegistrationCycle::whereIn('id', $studentIDs['registration_cycle_id'])
            ->whereHas('basic_details', function ($query) {

                $query->where('status', 'completed');
            });

        if ($data['selectedDistrict'] != 'null') {

            $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                $query->where('district_id', $data['selectedDistrict']);
            });
        }

        if ($data['selectedSex'] != 'null') {

            $students->whereHas('basic_details', function ($query) use ($data) {

                $query->where('gender', $data['selectedSex']);
            });
        }

        if ($data['selectedCategory'] != 'null') {

            if ($data['selectedCategory'] == 'bpl') {

                $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                    $query->where('category', 'bpl');
                });
            } else {

                $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                    $query->where('category', 'dg')
                        ->whereRaw("certificate_details->>'dg_type' = '" . $data['selectedCategory'] . "'");
                });
            }
        }

        if ($data['selectedSchool'] != 'null') {

            $students->where('allotted_school_id', $data['selectedSchool']);
        }

        if ($data['selectedNodal'] != 'null') {

            $students = \Models\RegistrationCycle::whereHas('application_details', function ($sub_query) use ($data) {

                $sub_query->where('session_year', $data['selectedCycle']);
            })->whereHas('basic_details', function ($query) {

                $query->where('status', 'completed');
            })
                ->get();

            $total_admitted = self::getStudentIds($students, $data['selectedNodal']);

            return count($total_admitted);
        }

        $total_unique_applications_received = $students->count();

        return $total_unique_applications_received;
    }

    public static function getTotalAllotted($state_id, $data)
    {
        $studentIDs = self::getStudentIdsBySession($data);

        $students = \Models\RegistrationCycle::whereIn('id', $studentIDs['registration_cycle_id'])
            ->whereHas('basic_details', function ($query) {

                $query->where('status', 'completed');
            })
            ->where('status', '<>', 'applied')
            ->where('document_verification_status', 'verified');

        if ($data['selectedDistrict'] != 'null') {

            $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                $query->where('district_id', $data['selectedDistrict']);
            });
        }

        if ($data['selectedSex'] != 'null') {

            $students->whereHas('basic_details', function ($query) use ($data) {

                $query->where('gender', $data['selectedSex']);
            });
        }

        if ($data['selectedCategory'] != 'null') {

            if ($data['selectedCategory'] == 'bpl') {

                $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                    $query->where('category', 'bpl');
                });
            } else {

                $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                    $query->where('category', 'dg')
                        ->whereRaw("certificate_details->>'dg_type' = '" . $data['selectedCategory'] . "'");
                });
            }
        }

        if ($data['selectedSchool'] != 'null') {

            $students->where('allotted_school_id', $data['selectedSchool']);
        }

        if ($data['selectedNodal'] != 'null') {

            $students = \Models\RegistrationCycle::whereHas('application_details', function ($sub_query) use ($data) {

                $sub_query->where('session_year', $data['selectedCycle']);
            })
                ->whereHas('basic_details', function ($query) {

                    $query->where('status', 'completed');
                })
                ->whereIn('status', ['allotted', 'enrolled'])
                ->where('document_verification_status', 'verified')
                ->get();

            $total_admitted = self::getStudentIds($students, $data['selectedNodal']);

            return count($total_admitted);
        }

        $total_allotted = $students->count();

        return $total_allotted;
    }

    public static function getTotalRejected($state_id, $data)
    {
        $studentIDs = self::getStudentIdsBySession($data);

        $students = \Models\RegistrationCycle::whereIn('id', $studentIDs['registration_cycle_id'])
            ->whereHas('basic_details', function ($query) {

                $query->where('status', 'completed');
            })
            ->where('status', 'rejected');

        if ($data['selectedDistrict'] != 'null') {

            $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                $query->where('district_id', $data['selectedDistrict']);
            });
        }

        if ($data['selectedSex'] != 'null') {

            $students->whereHas('basic_details', function ($query) use ($data) {

                $query->where('gender', $data['selectedSex']);
            });
        }

        if ($data['selectedCategory'] != 'null') {

            if ($data['selectedCategory'] == 'bpl') {

                $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                    $query->where('category', 'bpl');
                });
            } else {

                $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                    $query->where('category', 'dg')
                        ->whereRaw("certificate_details->>'dg_type' = '" . $data['selectedCategory'] . "'");
                });
            }
        }

        if ($data['selectedSchool'] != 'null') {

            $students->where('allotted_school_id', $data['selectedSchool']);
        }

        $total_rejected = $students->count();

        return $total_rejected;
    }

    public static function getTotalAdmitted($state_id, $data)
    {
        $studentIDs = self::getStudentIdsBySession($data);

        $students = \Models\RegistrationCycle::whereIn('id', $studentIDs['registration_cycle_id'])
            ->whereHas('basic_details', function ($query) {

                $query->where('status', 'completed');
            })
            ->where('status', 'enrolled');

        if ($data['selectedDistrict'] != 'null') {

            $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                $query->where('district_id', $data['selectedDistrict']);
            });
        }

        if ($data['selectedSex'] != 'null') {

            $students->whereHas('basic_details', function ($query) use ($data) {

                $query->where('gender', $data['selectedSex']);
            });
        }

        if ($data['selectedCategory'] != 'null') {

            if ($data['selectedCategory'] == 'bpl') {

                $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                    $query->where('category', 'bpl');
                });
            } else {

                $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                    $query->where('category', 'dg')
                        ->whereRaw("certificate_details->>'dg_type' = '" . $data['selectedCategory'] . "'");
                });
            }
        }

        if ($data['selectedSchool'] != 'null') {

            $students->where('allotted_school_id', $data['selectedSchool']);
        }

        if ($data['selectedNodal'] != 'null') {

            $students = \Models\RegistrationCycle::whereHas('application_details', function ($sub_query) use ($data) {

                $sub_query->where('session_year', $data['selectedCycle']);
            })
                ->whereHas('basic_details', function ($query) {

                    $query->where('status', 'completed');
                })
                ->where('status', 'enrolled')
                ->get();

            $total_admitted = self::getStudentIds($students, $data['selectedNodal']);

            return count($total_admitted);
        }

        $total_admitted = $students->count();

        return $total_admitted;
    }

    public static function getTotalVerified($state_id, $data)
    {
        $studentIDs = self::getStudentIdsBySession($data);

        $students = \Models\RegistrationCycle::whereIn('id', $studentIDs['registration_cycle_id'])
            ->whereHas('basic_details', function ($query) {

                $query->where('status', 'completed');
            })
            ->where('document_verification_status', 'verified');

        if ($data['selectedDistrict'] != 'null') {

            $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                $query->where('district_id', $data['selectedDistrict']);
            });
        }

        if ($data['selectedSex'] != 'null') {

            $students->whereHas('basic_details', function ($query) use ($data) {

                $query->where('gender', $data['selectedSex']);
            });
        }

        if ($data['selectedCategory'] != 'null') {

            if ($data['selectedCategory'] == 'bpl') {

                $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                    $query->where('category', 'bpl');
                });
            } else {

                $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                    $query->where('category', 'dg')
                        ->whereRaw("certificate_details->>'dg_type' = '" . $data['selectedCategory'] . "'");
                });
            }
        }

        if ($data['selectedSchool'] != 'null') {

            $students->where('allotted_school_id', $data['selectedSchool']);
        }

        if ($data['selectedNodal'] != 'null') {

            $students = \Models\RegistrationCycle::whereHas('application_details', function ($sub_query) use ($data) {

                $sub_query->where('session_year', $data['selectedCycle']);
            })
                ->whereHas('basic_details', function ($query) {

                    $query->where('status', 'completed');
                })
                ->where('document_verification_status', 'verified')
                ->get();

            $total_admitted = self::getStudentIds($students, $data['selectedNodal']);

            return count($total_admitted);
        }

        return $students->count();
    }

    public static function getCategoryType($sex_type)
    {

        $category = 'co-educational';

        if ($sex_type == 'male') {

            $category = 'boys';
        } elseif ($sex_type == 'female') {

            $category = 'girls';
        }

        return $category;
    }

    public static function getGroupGraphData($state_id, $data)
    {
        $students = RegistrationBasicDetail::select('id', 'gender')
            ->where('status', 'completed')
            ->where('state_id', $state_id)
            ->whereHas('registration_cycle', function ($query) use ($data) {

                $query->where('status', 'enrolled');
            });

        if ($data['selectedDistrict'] != 'null') {

            $students->whereHas('personal_details', function ($query) use ($data) {

                $query->where('district_id', $data['selectedDistrict']);
            });
        }

        if ($data['selectedSex'] != 'null') {

            $students->where('gender', $data['selectedSex']);
        }

        if ($data['selectedNodal'] != 'null') {

            $school_nodals = \Models\SchoolNodal::select('id', 'school_id', 'nodal_id')
                ->where('nodal_id', $data['selectedNodal'])
                ->pluck('school_id')
                ->all();

            $students->whereHas('registration_cycle', function ($query) use ($school_nodals) {
                $query->whereIn('allotted_school_id', $school_nodals);
            });
        }

        $total_students = self::getTotalStudentsCount($students);
        $total_ews_students = self::getTotalEwsStudentsCount($students);
        $total_dg_students = self::getTotalDgStudentsCount($state_id, $data);

        $total_percent = [];

        if ($total_students > 0) {

            $total_percent['ews'] = $total_ews_students;

            $total_percent['dg'] = $total_dg_students;

            $total_percent['ews_percentage'] = round(($total_ews_students * 100) / $total_students, 1);

            $total_percent['dg_percentage'] = round(($total_dg_students * 100) / $total_students, 1);

            $total_percent['show'] = true;
        } else {

            $total_percent['show'] = false;
        }

        return $total_percent;
    }

    public static function getTotalStudentsCount($students)
    {

        $total_students = $students->count();

        return $total_students;
    }

    public static function getTotalDgStudentsCount($state_id, $data)
    {

        $students = RegistrationBasicDetail::select('id', 'gender')
            ->where('status', 'completed')
            ->where('state_id', $state_id)
            ->whereHas('registration_cycle', function ($query) use ($data) {

                $query->where('status', 'enrolled');
            });

        if ($data['selectedDistrict'] != 'null') {

            $students->whereHas('personal_details', function ($query) use ($data) {

                $query->where('district_id', $data['selectedDistrict']);
            });
        }

        if ($data['selectedSex'] != 'null') {

            $students->where('gender', $data['selectedSex']);
        }

        if ($data['selectedNodal'] != 'null') {

            $school_nodals = \Models\SchoolNodal::select('id', 'school_id', 'nodal_id')
                ->where('nodal_id', $data['selectedNodal'])
                ->pluck('school_id')
                ->all();

            $students->whereHas('registration_cycle', function ($query) use ($school_nodals) {
                $query->whereIn('allotted_school_id', $school_nodals);
            });
        }

        $students->whereHas('personal_details', function ($query) {
            $query->where('category', 'dg');
        })
            ->count();

        $total_dg_students = $students->count();

        return $total_dg_students;
    }

    public static function getTotalEwsStudentsCount($students)
    {

        $total_ews_students = $students->whereHas('personal_details', function ($query) {
            $query->where('category', 'ews')->orWhere('category', 'bpl');
        })
            ->count();

        return $total_ews_students;
    }

    public static function getGenderGraphData($state_id, $data)
    {
        if ($data['selectedCycle'] == 'null') {

            $data['selectedCycle'] = \Helpers\ApplicationCycleHelper::getLatestCycle()->session_year;
        }

        $students = RegistrationCycle::select('id', 'registration_id', 'allotted_school_id')
            ->with('basic_details')
            ->where('status', 'enrolled')
            ->whereHas('basic_details', function ($query) use ($state_id) {
                $query->where('state_id', $state_id);
            })
            ->whereHas('application_details', function ($query) use ($data) {

                $query->where('session_year', $data['selectedCycle']);
            });

        if ($data['selectedDistrict'] != 'null') {

            $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                $query->where('district_id', $data['selectedDistrict']);
            });
        }

        if ($data['selectedCategory'] != 'null') {

            if ($data['selectedCategory'] == 'bpl') {

                $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                    $query->where('category', 'bpl');
                });
            } else {

                $students->whereHas('basic_details.personal_details', function ($query) use ($data) {

                    $query->where('category', 'dg')
                        ->whereRaw("certificate_details->>'dg_type' = '" . $data['selectedCategory'] . "'");
                });
            }
        }

        if ($data['selectedSchool'] != 'null') {

            $students->where('allotted_school_id', $data['selectedSchool']);
        }

        if ($data['selectedSex'] != 'null') {

            $students->whereHas('basic_details', function ($query) use ($data) {

                $query->where('gender', $data['selectedSex']);
            });
        }

        if ($data['selectedNodal'] != 'null') {

            $school_nodals = \Models\SchoolNodal::select('id', 'school_id', 'nodal_id')
                ->where('nodal_id', $data['selectedNodal'])
                ->pluck('school_id')
                ->all();

            $students->whereIn('allotted_school_id', $school_nodals);
        }

        $students = $students->get();

        $male_students = 0;
        $female_students = 0;
        $transgender = 0;

        foreach ($students as $key => $student) {

            if ($student->basic_details->gender == 'male') {

                $male_students++;
            } elseif ($student->basic_details->gender == 'female') {

                $female_students++;
            } else {

                $transgender++;
            }
        }

        $total_data = [];

        if ($students->count() > 0) {
            $total_data['boys'] = $male_students;

            $total_data['girls'] = $female_students;

            $total_data['transgender'] = $transgender;

            $total_data['boys_percentage'] = round(($male_students * 100) / $students->count(), 1);

            $total_data['girls_percentage'] = round(($female_students * 100) / $students->count(), 1);

            $total_data['transgender_percentage'] = round(($transgender * 100) / $students->count(), 1);
        }

        $total_data['show'] = $students->count() > 0 ? true : false;

        return $total_data;
    }

    public static function getStudentIds($students, $nodal_id)
    {
        $schoolIds = \Models\SchoolNodal::where('nodal_id', $nodal_id)
            ->pluck('school_id')
            ->toArray();

        $reg_cycle_ids = [];

        foreach ($students as $student) {

            if (isset($student->preferences[0]) && in_array($student->preferences[0], $schoolIds)) {

                array_push($reg_cycle_ids, $student->id);

                continue;
            }

            if (!isset($student->preferences[0])) {

                if (isset($student->nearby_preferences[0]) && in_array($student->nearby_preferences[0], $schoolIds)) {

                    array_push($reg_cycle_ids, $student->id);
                }
            }
        }

        return $reg_cycle_ids;
    }

    private static function getStudentIdsBySession($data)
    {
        $latest_application_cycle = \Helpers\ApplicationCycleHelper::getLatestCycle();

        if ($data['selectedCycle'] == 'null') {

            $data['selectedCycle'] = $latest_application_cycle->session_year;
        }

        $students = \Models\RegistrationCycle::whereHas('application_details', function ($query) use ($data) {

            $query->where('session_year', $data['selectedCycle']);
        })
            ->get();

        $studentIDs = [
            'registration_id' => $students->pluck('registration_id')->toArray(),
            'registration_cycle_id' => $students->pluck('id')->toArray(),
        ];

        if ($latest_application_cycle->cycle > 1) {

            // get users which registered for second cycle
            // remove there first cycle entry

            $usersUnique = $students->unique('registration_id');

            $usersDupesRegistrationId = $students->diff($usersUnique)->pluck('id')->toArray();

            $delStudentIds = $students->whereIn('id', $usersDupesRegistrationId)
                ->where('cycle', '<', $latest_application_cycle->cycle)
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
