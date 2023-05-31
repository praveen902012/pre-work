<?php

namespace Redlof\RoleStateAdmin\Controllers\School;

use Exceptions\ValidationFailedException;
use Illuminate\Database\Eloquent\Builder;
use Models\School;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class SchoolViewController extends RoleStateAdminBaseController
{

    public function getSchoolView()
    {
        $years = $this->data['all_application_cycle']
            ->pluck('session_year')
            ->sort()
            ->unique()
            ->reverse()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "State Admin | Schools";

        return view('stateadmin::school.viewschool', $this->data);
    }

    public function getSchoolEditView()
    {
        $years = $this->data['all_application_cycle']
            ->pluck('session_year')
            ->sort()
            ->unique()
            ->reverse()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "State Admin | Schools";

        return view('stateadmin::school.viewschooledit', $this->data);
    }

    public function getStudentEditView()
    {
        $years = $this->data['all_application_cycle']
            ->pluck('session_year')
            ->sort()
            ->unique()
            ->reverse()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "State Admin | Edit Students";

        return view('stateadmin::student.viewstudentedit', $this->data);
    }

    public function getSingleSchoolView($school_id)
    {

        $levels = [];

        $regions = [];

        $school = School::with(['schooladmin.user', 'locality', 'sublocality', 'subsublocality', 'school_bank_details', 'regions', 'cluster'])->find($school_id);

        // Get current school
        $currSchoolCycle = \Models\SchoolCycle::where('school_id', $school->id)->where('application_cycle_id', $this->data['latest_application_cycle']->id)->first();

        $this->data['title'] = $school->name . " | School details";

        $this->data['currSchoolCycle'] = $currSchoolCycle;

        foreach ($school->levels as $key => $value) {

            $level = [];

            $level['id'] = $value;

            $val = \Models\Level::select('level')->where('id', $value)->first();

            $level['name'] = $val->level;

            array_push($levels, $level);
        }

        $regions = \Models\SchoolRange::where('school_id', $school_id)
            ->where('range', '1-3')
            ->select('id', 'regions')
            ->first();

        $selected_region = [];

        if (count($regions) > 0) {
            $selected_region = $regions['regions'];
        }

        $regions = \Models\Locality::select('name')
            ->where('block_id', $school->sub_block_id)
            ->whereNotIn('id', [$school->locality_id])
            ->whereIn('id', $selected_region)
            ->get();

        $sub_regions = \Models\Locality::select('name')
            ->whereHas('block.district', function ($subQuery) use ($school) {
                $subQuery = $subQuery->where('id', $school->district_id);
            })
            ->where('block_id', '!=', $school->sub_block_id)
            ->whereNotIn('id', [$school->locality_id])
            ->whereIn('id', $selected_region)
            ->get();

        $school['sub_block_name'] = '';

        if ($school->sub_block_id != null && $school->sub_block_id != '') {
            $subdata = \Models\Block::where('id', $school['sub_block_id'])->first();
            $school['sub_block_name'] = $subdata->name;
        }

        $students = \Models\RegistrationCycle::where('application_cycle_id', $this->data['latest_application_cycle']->id)
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

        $school->no_reg_students = $students_count;

        $school->only_no_reg_students = $only_students_count;

        $this->data['school'] = $school;

        $this->data['levels'] = $levels;

        $this->data['regions'] = $regions;

        $this->data['sub_regions'] = $sub_regions;

        $year = $this->data['latest_application_cycle']['session_year'];

        $levels = \Models\Level::select('id', 'level')->whereIn('id', $school['levels'])->get();

        $seat_info = \Models\SchoolSeatInfo::where('school_id', $school->id)
            ->where('level_id', $levels[0]->id)
            ->orderBy('year', 'desc')
            ->limit(3)
            ->get();

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

        // check school is in current year or not

        $school_levels = \Models\SchoolLevelInfo::where('school_id', $school->id)
            ->select('level_id', 'available_seats', 'total_seats')
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->whereIn('level_id', $school['levels'])
            ->get();

        $this->data['pastInfo'] = $pastInfo;
        $this->data['year'] = $year;
        $this->data['school_levels'] = $school_levels;

        return view('stateadmin::school.viewsingleschool', $this->data);
    }

    public function getSubjectsView()
    {

        $this->data['title'] = "State Admin | Subjects";

        return view('stateadmin::school.subjects', $this->data);
    }

    public function getAllAppliedStudentOfCollege($udise)
    {

        $this->data['title'] = "Applied Student | School";

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

        $this->data['applied_student'] = $applied_student;
        $this->data['udise'] = $udise;

        return view('stateadmin::student.school-applied-student', $this->data);
    }
}
