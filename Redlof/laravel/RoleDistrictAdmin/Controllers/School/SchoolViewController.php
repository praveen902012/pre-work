<?php
namespace Redlof\RoleDistrictAdmin\Controllers\School;

use Models\School;
use Redlof\RoleDistrictAdmin\Controllers\Role\RoleDistrictAdminBaseController;

class SchoolViewController extends RoleDistrictAdminBaseController
{

    public function __construct()
    {

        parent::__construct();
    }

    public function getSchoolAllView()
    {

        $this->data['title'] = "All Schools";

        $years = $this->data['all_application_cycle']
            ->pluck('session_year')
            ->sort()
            ->reverse()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['district'] = $this->district;

        return view('districtadmin::school.schools', $this->data);

    }

    public function getSchoolRegisteredView()
    {
        $years = $this->data['all_application_cycle']
            ->pluck('session_year')
            ->sort()
            ->reverse()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "Registered Schools";
        $this->data['district'] = $this->district;

        return view('districtadmin::school.schools-registered', $this->data);

    }

    public function getSchoolVerifiedView()
    {
        $years = $this->data['all_application_cycle']
            ->pluck('session_year')
            ->sort()
            ->reverse()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "Verified Schools";
        $this->data['district'] = $this->district;

        return view('districtadmin::school.schools-verified', $this->data);

    }

    public function getSchoolAssignedView()
    {

        $years = $this->data['all_application_cycle']
            ->pluck('session_year')
            ->sort()
            ->reverse()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "Assigned Schools";
        $this->data['district'] = $this->district;

        return view('districtadmin::school.schools-assigned', $this->data);

    }

    public function getSchoolRejectedView()
    {

        $years = $this->data['all_application_cycle']
            ->pluck('session_year')
            ->sort()
            ->reverse()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "Rejected Schools";
        $this->data['district'] = $this->district;

        return view('districtadmin::school.schools-rejected', $this->data);

    }

    public function getSchoolBannedView()
    {

        $years = $this->data['all_application_cycle']
            ->pluck('session_year')
            ->sort()
            ->reverse()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "Banned Schools";
        $this->data['district'] = $this->district;

        return view('districtadmin::school.schools-banned', $this->data);

    }

    public function getEachSchoolView($id)
    {

        $this->data['school'] = School::with(['schooladmin.user', 'language'])->find($id);

        return view('districtadmin::school.vieweachschool', $this->data);

    }

    public function getSchoolDetailView($school_id)
    {

        $this->data['school'] = School::with(['schooladmin.user', 'language'])
            ->find($school_id);

        $this->data['district'] = $this->district;

        $this->data['title'] = "School Details";

        return view('districtadmin::school.school-details', $this->data);

    }

    public function schoolDetailsView($school_id)
    {

        $levels = [];

        $regions = [];

        $seats = [];

        $school = School::with(['schooladmin.user', 'locality', 'sublocality', 'subsublocality', 'school_bank_details', 'regions', 'cluster'])
            ->find($school_id);

        $this->data['school_fee'] = \Models\SchoolLevelInfo::where('school_id', $school_id)
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->with('level_info')
            ->orderBy('level_id')
            ->get();

        foreach ($school->levels as $key => $value) {

            $level = [];

            $seat = [];

            $level['id'] = $value;

            $val = \Models\Level::select('level')->where('id', $value)->first();

            $seatLevel = \Models\SchoolLevelInfo::where('school_id', $school_id)
                ->where('session_year', $this->data['latest_application_cycle']['session_year'])
                ->where('level_id', $value)
                ->with('level_info')
                ->first();

            $seat['class'] = $seatLevel ? $seatLevel->level_info->level : $val->level;
            $seat['available_seats'] = $seatLevel ? $seatLevel->available_seats : 0;

            $level['name'] = $val->level;

            array_push($levels, $level);

            array_push($seats, $seat);

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

        if (!$school->cycle) {
            $school->cycle = 1;
        }

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

        $this->data['pastInfo'] = $pastInfo;

        $this->data['year'] = $year;

        $this->data['school'] = $school;

        $this->data['levels'] = $levels;

        $this->data['seats'] = $seats;

        $this->data['regions'] = $regions;

        $this->data['sub_regions'] = $sub_regions;

        $this->data['district'] = $this->district;

        $this->data['title'] = "School Details";

        return view('districtadmin::school.school-details', $this->data);

    }

    public function getSchoolReimbursementView()
    {

        $this->data['district'] = $this->district;

        $this->data['title'] = "School Reimbursement";

        return view('districtadmin::school.school-reimbursement', $this->data);

    }

    public function getStudentReimbursementView()
    {

        $this->data['district'] = $this->district;

        $this->data['title'] = "Student Reimbursement";

        return view('districtadmin::school.student-reimbursement', $this->data);

    }

    public function getSchoolStudentReimbursementView($school_id)
    {

        $this->data['school_id'] = $school_id;

        $this->data['district'] = $this->district;

        $this->data['title'] = "Student Reimbursement";

        return view('districtadmin::school.school-student-reimbursement', $this->data);

    }

}
