<?php
namespace Helpers;

class SchoolHelper
{

    public static function getClassUpto($class)
    {

        $new_class_array = [];

        $classarray = array("Pre-Primary", "KG 1", "KG 2", "Class 1", "Class 2", "Class 3", "Class 4", "Class 5", "Class 6", "Class 7", "Class 8");

        $classlevels = array("pre-primary", "kg1", "kg2", "class1", "class2", "class3", "class4", "class5", "class6", "class7", "class8");

        if (($key = array_search($class, $classlevels)) !== false) {

            $new_class_array = array_slice($classarray, 0, $key + 1, true);

        } else {

            return $classarray;

        }

        return $new_class_array;
    }

    public static function deleteDuplicateSchoolLevelInfos()
    {

        $latest_app_cyc = \Helpers\ApplicationCycleHelper::getLatestCycle();

        $years = [2018, 2019, 2020, 2021];

        foreach ($years as $year) {

            $notDeletingIds = [];

            $schoolLevels = \Models\SchoolLevelInfo::select('id', 'deleted_at', 'level_id', 'school_id', 'available_seats')
                ->whereYear('created_at', '=', $year)
                ->withTrashed()
                ->orderBy('school_id', 'asc')
                ->has('school')
                ->get();

            $all_level_ids = $schoolLevels->pluck('id');

            $schoolLevels = $schoolLevels->groupBy('school_id');

            foreach ($schoolLevels as $school) {

                $single_school_all_levels = $school->groupBy('level_id');

                foreach ($single_school_all_levels as $levels) {

                    if ($year == $latest_app_cyc->session_year) {

                        $each_level_max = $levels->where('deleted_at', null)->sortByDesc('available_seats')->first();

                    } else {

                        $each_level_max = $levels->sortByDesc('available_seats')->first();
                    }

                    if ($each_level_max) {

                        array_push($notDeletingIds, $each_level_max->id);
                    }
                }
            }

            $deletingIds = $all_level_ids->diff($notDeletingIds)->values();

            if ($deletingIds) {

                $chunk = collect($deletingIds)->chunk(10);

                foreach ($chunk as $del_ids) {

                    \Models\SchoolLevelInfo::whereIn('id', $del_ids)->forceDelete();
                }
            }
        }

        \Models\SchoolLevelInfo::withTrashed()->restore();

        \Models\SchoolLevelInfo::whereNull('available_seats')->update(['available_seats' => 0]);

        return $deletingIds;
    }

    public static function fillData()
    {
        $years = [2018, 2019, 2020, 2021];

        foreach ($years as $year) {

            \Models\SchoolLevelInfo::whereYear('created_at', '=', $year)
                ->whereNull('session_year')
                ->update(['session_year' => $year]);
        }

        return true;
    }

    public static function addSchoolLevels($school_id)
    {

        $application_cycle = \Helpers\ApplicationCycleHelper::getLatestCycle();

        $school = \Models\School::find($school_id);

        $existing_fee_details = \Models\SchoolLevelInfo::where('school_id', $school->id)
            ->where('session_year', $application_cycle->session_year)
            ->count();

        if ($existing_fee_details) {

            return true;
        }

        $highest_class_id = self::getClassID($school->type);

        $entry_class_id = (int) $school->levels[0];

        $level_ids = \Models\Level::where('id', '>=', $entry_class_id)
            ->where('id', '<=', $highest_class_id)
            ->where('id', '<=', 18)
            ->pluck('id')
            ->toArray();

        $levels_to_add = [];

        foreach ($level_ids as $level_id) {

            $temp_level_info = [
                'level_id' => $level_id,
                'school_id' => $school->id,
                'tution_fee' => 0,
                'other_fee' => 0,
                'available_seats' => 0,
                'total_seats' => 0,
                'application_cycle_id' => $application_cycle->id,
                'session_year' => $application_cycle->session_year,
                'created_at' => \Carbon::now(),
                'updated_at' => \Carbon::now(),
            ];

            $levels_to_add[] = $temp_level_info;
        }

        if ($levels_to_add) {

            \Models\SchoolLevelInfo::insert($levels_to_add);
        }

        return true;
    }

    public static function updateSchoolLevels($school_id, $request)
    {

        $application_cycle = \Helpers\ApplicationCycleHelper::getLatestCycle();

        $school = \Models\School::find($school_id);

        $previous_level_ids = \Models\SchoolLevelInfo::where('school_id', $school->id)
            ->where('session_year', $application_cycle->session_year)
            ->orderBy('level_id', 'asc')
            ->get()
            ->pluck('level_id')
            ->toArray();

        $highest_class_id = self::getClassID($request['type']);

        $entry_class_id = $request['level'];

        $new_level_ids = \Models\Level::where('id', '>=', $entry_class_id)
            ->where('id', '<=', $highest_class_id)
            ->where('id', '<=', 18)
            ->pluck('id')
            ->toArray();

        $levels_to_add = [];

        foreach ($new_level_ids as $level_id) {

            if (in_array($level_id, $previous_level_ids)) {

                continue; // skip if already present
            }

            $temp_level_info = [
                'level_id' => $level_id,
                'school_id' => $school->id,
                'tution_fee' => 0,
                'other_fee' => 0,
                'available_seats' => 0,
                'total_seats' => 0,
                'application_cycle_id' => $application_cycle->id,
                'session_year' => $application_cycle->session_year,
                'created_at' => \Carbon::now(),
                'updated_at' => \Carbon::now(),
            ];

            $levels_to_add[] = $temp_level_info;
        }

        if ($levels_to_add) {

            \Models\SchoolLevelInfo::insert($levels_to_add);
        }

        if ($previous_level_ids) {

            $deletingLevels = array_values(array_diff($previous_level_ids, $new_level_ids));

            if ($deletingLevels) {

                \Models\SchoolLevelInfo::where('school_id', $school->id)
                    ->where('session_year', $application_cycle->session_year)
                    ->whereIn('level_id', $deletingLevels)
                    ->forceDelete();
            }
        }

        return true;
    }

    public static function updateSchoolLevelSeats($school_id, $request)
    {

        foreach ($request['feestructure'] as $level) {

            $updatingLevel = \Models\SchoolLevelInfo::find($level['id']);

            if (empty($updatingLevel)) {
                continue;
            }

            $updatingLevel->tution_fee = $level['tution_fee'];

            $updatingLevel->other_fee = $level['other_fee'];

            $updatingLevel->available_seats = $level['available_seats'];

            $updatingLevel->total_seats = $level['total_seats'] != 'null' ? $level['total_seats'] : null;

            $updatingLevel->rte_seats = $level['rte_seats'];

            $updatingLevel->save();
        }

        $application_cycle = \Helpers\ApplicationCycleHelper::getLatestCycle();

        $entrySeats = $request['seatinfo'][0];

        $updatingEntryLevel = \Models\SchoolLevelInfo::whereHas('level_info', function ($query) use ($entrySeats) {

            $query->where('level', $entrySeats['level']);
        })
            ->where('school_id', $school_id)
            ->where('session_year', $application_cycle->session_year)
            ->first();

        if (empty($updatingEntryLevel)) {
            return true;
        }

        $updatingEntryLevel->available_seats = $entrySeats['available_seats'];

        $updatingEntryLevel->total_seats = $entrySeats['total_seats'];

        $updatingEntryLevel->save();

        return true;
    }

    public static function getClassID($slug)
    {
        $classes = [];

        $classes['kg2'] = 3;
        $classes['class1'] = 4;
        $classes['class2'] = 12;
        $classes['class3'] = 13;
        $classes['class4'] = 14;
        $classes['class5'] = 15;
        $classes['class6'] = 16;
        $classes['class7'] = 17;
        $classes['class8'] = 18;
        $classes['class9'] = 18;
        $classes['class10'] = 18;
        $classes['class11'] = 18;
        $classes['class12'] = 18;

        return $classes[$slug];
    }

    public static function getSchoolEntryLevel($school_id, $session_year = null)
    {

        if ($session_year == null) {

            $session_year = \Helpers\ApplicationCycleHelper::getLatestCycle()->session_year;
        }

        $school = \Models\School::find($school_id);

        $e_level = \Models\SchoolLevelInfo::where('school_id', $school->id)
            ->whereIn('level_id', $school->levels)
            ->where('session_year', $session_year)
            ->first();

        return $e_level;
    }

    public static function getSchoolAllotment($school)
    {

        $applicationCycles = \Models\ApplicationCycle::orderBy('created_at', 'desc')->get();

        foreach ($applicationCycles as $applicationCycle) {

            $students = \Models\RegistrationCycle::where('application_cycle_id', $applicationCycle->id)
                ->get();

            $students_count = 0;
            $only_students_count = 0;

            foreach ($students as $student) {

                if (!empty($student->preferences)) {

                    if (in_array($school->id, $student->preferences)) {

                        $students_count++;

                        if (count($student->preferences) == 1 && empty($student->nearby_preferences)) {

                            $only_students_count++;
                        }

                        continue;
                    }
                }

                if (!empty($student->nearby_preferences)) {

                    if (in_array($school->id, $student->nearby_preferences)) {

                        $students_count++;

                        if (count($student->nearby_preferences) == 1 && empty($student->preferences)) {

                            $only_students_count++;
                        }
                    }
                }
            }

            $applicationCycle->no_reg_students = $students_count;

            $applicationCycle->only_no_reg_students = $only_students_count;

            $applicationCycle->entry_class = \Models\SchoolLevelInfo::where('session_year', $applicationCycle->session_year)
                ->whereIn('level_id', $school->levels)
                ->where('school_id', $school->id)
                ->with('level_info')
                ->first();

            $applicationCycle->school_cycle = \Models\SchoolCycle::where('school_id', $school->id)
                ->where('application_cycle_id', $applicationCycle->id)
                ->first();

            $applicationCycle->alloted_students = \Models\RegistrationCycle::where('allotted_school_id', $school->id)
                ->whereIn('status', ['allotted', 'enrolled'])
                ->where('application_cycle_id', $applicationCycle->id)
                ->with(['basic_details'])
                ->distinct()
                ->get();

            $applicationCycle->enrolled_students = \Models\RegistrationCycle::where('allotted_school_id', $school->id)
                ->where('status', 'enrolled')
                ->where('application_cycle_id', $applicationCycle->id)
                ->with(['basic_details'])
                ->distinct()
                ->get();

            $applicationCycle->dismissed_students = \Models\RegistrationCycle::where('allotted_school_id', $school->id)
                ->where('status', 'dismissed')
                ->where('application_cycle_id', $applicationCycle->id)
                ->with(['basic_details'])
                ->distinct()
                ->get();
        }

        return $applicationCycles;

    }
}
