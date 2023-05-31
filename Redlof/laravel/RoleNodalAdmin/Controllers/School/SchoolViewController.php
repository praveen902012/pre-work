<?php
namespace Redlof\RoleNodalAdmin\Controllers\School;

use Models\School;
use Models\State;
use Redlof\RoleNodalAdmin\Controllers\Role\RoleNodalAdminBaseController;

class SchoolViewController extends RoleNodalAdminBaseController
{

    public function __construct()
    {

        parent::__construct();
    }

    public function getAllSchoolsView()
    {
        $years = $this->data['all_application_cycle']
            ->sortByDesc('session_year')
            ->pluck('session_year')
            ->unique()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "Nodal Admin | Schools";

        $breadcrumb['Schools'] = route('school.all-schools');

        $this->data['breadcrumbs'] = $breadcrumb;

        return view('nodaladmin::school.schools', $this->data);
    }

    public function getSchoolView()
    {
        $years = $this->data['all_application_cycle']
            ->sortByDesc('session_year')
            ->pluck('session_year')
            ->unique()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "Registered Schools";

        $breadcrumb['Schools Under Review'] = route('school.registered-schools');

        $this->data['breadcrumbs'] = $breadcrumb;

        return view('nodaladmin::school.registered-schools', $this->data);
    }

    public function getRegisteredSchoolView()
    {
        $years = $this->data['all_application_cycle']
            ->sortByDesc('session_year')
            ->pluck('session_year')
            ->unique()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "Nodal Admin | Verified Schools";

        $breadcrumb['Registered Schools'] = route('school.verified-schools');

        $this->data['breadcrumbs'] = $breadcrumb;

        return view('nodaladmin::school.verified-schools', $this->data);
    }

    public function getBannedSchoolView()
    {
        $years = $this->data['all_application_cycle']
            ->sortByDesc('session_year')
            ->pluck('session_year')
            ->unique()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "Nodal Admin | Banned Schools";

        $breadcrumb['Banned Schools'] = route('school.banned-schools');

        $this->data['breadcrumbs'] = $breadcrumb;

        return view('nodaladmin::school.banned-schools', $this->data);
    }

    public function getRejectedSchoolView()
    {
        $years = $this->data['all_application_cycle']
            ->sortByDesc('session_year')
            ->pluck('session_year')
            ->unique()
            ->values()
            ->all();

        $this->data['years'] = $years;

        $this->data['title'] = "Nodal Admin | Rejected Schools";

        $breadcrumb['Rejected Schools'] = route('school.rejected-schools');

        $this->data['breadcrumbs'] = $breadcrumb;

        return view('nodaladmin::school.rejected-schools', $this->data);
    }

    public function getAddSchoolView()
    {
        $this->data['title'] = "Nodal Admin | Add New School";

        $breadcrumb['Add School'] = route('school.add-school');

        $this->data['breadcrumbs'] = $breadcrumb;

        $state = State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($this->data['state']->id);

        $this->data['state'] = $state;

        return view('nodaladmin::school.school-registration-primary', $this->data);
    }

    public function getAddSchoolAddressView($udise)
    {
        $this->data['title'] = "Nodal Admin | Add New School";

        $breadcrumb['Add School'] = route('school.add-school');

        $this->data['breadcrumbs'] = $breadcrumb;

        $state = State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($this->data['state']->id);

        $this->data['state'] = $state;

        $this->data['udise'] = $udise;

        return view('nodaladmin::school.school-registration-address', $this->data);
    }

    public function getAddSchoolRegionView($udise)
    {
        $this->data['title'] = "Nodal Admin | Add New School";

        $breadcrumb['Add School'] = route('school.add-school');

        $this->data['breadcrumbs'] = $breadcrumb;

        $state = State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($this->data['state']->id);

        $this->data['state'] = $state;

        $this->data['udise'] = $udise;

        return view('nodaladmin::school.school-registration-region-selection', $this->data);
    }

    public function schoolDetailsView($school_id)
    {
        $levels = [];

        $regions = [];

        $breadcrumb['Add School'] = route('school.add-school');

        $this->data['breadcrumbs'] = $breadcrumb;

        $school = School::with(['schooladmin.user', 'locality', 'sublocality', 'subsublocality', 'school_bank_details', 'regions', 'cluster'])
            ->find($school_id);

        $this->data['title'] = $school->name . " | School details";

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

            if(isset($seat_info[0])){
                $pastInfo->first_year = (int) $seat_info[0]->total_seats;
            }
            if(isset($seat_info[1])){
                $pastInfo->second_year = (int) $seat_info[1]->total_seats;
            }
            if(isset($seat_info[2])){
                $pastInfo->third_year = (int) $seat_info[2]->total_seats;
            }

        }

        $this->data['pastInfo'] = $pastInfo;
        $this->data['year'] = $year;

        return view('nodaladmin::school.school-details', $this->data);
    }

    public function editSchoolPrimaryView($school_id)
    {
        $school = \Models\School::find($school_id);

        $disable_edit = true;

        if ($school->application_status == 'registered') {

            $disable_edit = false;

        }

        // if ($school->application_status == 'verified') {

        //     $disable_edit = $this->checkLotteryParticipation($school);

        // }

        $this->data['disable_edit'] = $disable_edit;

        $this->data['school'] = $school;

        $this->data['title'] = "Edit School Details";

        return view('nodaladmin::school.edit-school', $this->data);

    }

    public function editSchoolAddressView($udise)
    {
        $school = \Models\School::where('udise', $udise)->first();

        $disable_edit = true;

        if ($school->application_status == 'registered') {

            $disable_edit = false;

        }

        // if ($school->application_status == 'verified') {

        //     $disable_edit = $this->checkLotteryParticipation($school);

        // }

        $this->data['disable_edit'] = $disable_edit;

        $this->data['school'] = $school;

        $this->data['title'] = "Edit Address Details";

        $this->data['udise'] = $udise;

        return view('nodaladmin::school.update-address', $this->data);

    }

    public function editSchoolRegionView($udise)
    {
        $school = \Models\School::where('udise', $udise)->first();

        $disable_edit = true;

        if ($school->application_status == 'registered') {

            $disable_edit = false;

        }

        // if ($school->application_status == 'verified') {

        //     $disable_edit = $this->checkLotteryParticipation($school);

        // }

        $this->data['disable_edit'] = $disable_edit;

        $this->data['school'] = $school;

        $this->data['title'] = "Edit Region Selection";

        $this->data['udise'] = $udise;

        return view('nodaladmin::school.update-region', $this->data);

    }

    public function editSchoolFeeView($udise)
    {
        $school = \Models\School::where('udise', $udise)->first();

        $year = $this->data['latest_application_cycle']['session_year'];

        $this->data['year'] = $year;

        $disable_edit = true;

        if ($school->application_status == 'registered') {

            $disable_edit = false;

        }

        // if ($school->application_status == 'verified') {

        //     $disable_edit = $this->checkLotteryParticipation($school);

        // }

        $this->data['disable_edit'] = $disable_edit;

        $this->data['school'] = $school;

        $this->data['title'] = "Edit Fee Details";

        $this->data['udise'] = $udise;

        return view('nodaladmin::school.update-fee', $this->data);

    }

    public function editSchoolBankView($udise)
    {
        $school = \Models\School::where('udise', $udise)->first();

        $disable_edit = true;

        if ($school->application_status == 'registered') {

            $disable_edit = false;

        }

        // if ($school->application_status == 'verified') {

        //     $disable_edit = $this->checkLotteryParticipation($school);

        // }

        $this->data['disable_edit'] = $disable_edit;

        $this->data['school'] = $school;

        $this->data['title'] = "Edit Bank Details";

        $this->data['udise'] = $udise;

        return view('nodaladmin::school.update-bank', $this->data);

    }

    public function getDeleteSchoolView()
    {
        $this->data['title'] = "Edit Bank Details";

        return view('nodaladmin::school.delete-repeat', $this->data);
    }

    public function checkLotteryParticipation($school)
    {
        $lottery = \Models\ApplicationCycle::get();

        $completed_lottery = $lottery->where('status', 'completed')->count();

        if ($completed_lottery > 0) {

            $latest_completed_lottery = \Models\ApplicationCycle::where('status', 'completed')
                ->orderBy('created_at', 'desc')
                ->first();

            $latest_end_date = \Carbon::parse($latest_completed_lottery->reg_end_date);

            if ($school->created_at->lte($latest_end_date)) {

                return true;

            } else {

                return false;

            }

        } else {

            return false;
        }

    }

}