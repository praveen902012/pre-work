<?php
namespace Redlof\RoleAdmin\Controllers\State;

use Models\State;
use Redlof\RoleAdmin\Controllers\State\StateBaseController;

class StateViewController extends StateBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getStates()
    {

        $this->data['title'] = 'States';

        return view('admin::state.states', $this->data);
    }

    public function getStateAdminView($state)
    {

        $this->data['title'] = 'State Administrators';

        $this->data['breadcrumbs'] = [
            'All' => url('state/admin'),
        ];

        return view('admin::state.state-admin', $this->data);
    }

    public function getDeactivatedStateAdminView($state)
    {

        $this->data['title'] = 'Deactivated State Administrators';

        $this->data['breadcrumbs'] = [
            'All' => url('state/admin'),
        ];

        return view('admin::state.deactivated-state-admin', $this->data);
    }

    public function getStateBriefView($state_id)
    {

        $state = State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($state_id);

        $this->data['breadcrumbs'] = [
            $state->name => url('admin/states/' . $state->slug),
        ];

        $this->data['state'] = $state;

        return view('admin::state.state-brief-view', $this->data);
    }

    public function getStateAdminBriefView($state_admin_id)
    {

        $state_admin = \Models\StateAdmin::with([
            'user'])
            ->find($state_admin_id);

        $this->data['state'] = 'Data';

        $this->data['state_admin'] = $state_admin;

        return view('admin::state.state-admin-brief-view', $this->data);
    }

    public function getDistrictBriefView($district_id)
    {

        $district = \Models\District::with([
            'districtadmin.user'])
            ->find($district_id);

        $state = State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($district->state_id);

        $this->data['state'] = $state;

        $this->data['district'] = $district;

        return view('admin::state.district-brief-view', $this->data);
    }

    public function getDistrictAdminBriefView($district_admin_id)
    {

        $district_admin = \Models\StateDistrictAdmin::with([
            'user'])
            ->find($district_admin_id);

        $this->data['district_admin'] = $district_admin;

        $this->data['state'] = 'Data';

        return view('admin::state.district-admin-brief-view', $this->data);
    }

    public function getDeactivatedDistrictAdminBriefView($district_admin_id)
    {

        $district_admin = \Models\StateDistrictAdmin::with([
            'user'])
            ->find($district_admin_id);

        $this->data['district_admin'] = $district_admin;

        $this->data['state'] = 'Data';

        return view('admin::state.deactivated-district-admin-brief-view', $this->data);
    }

    public function getNodalAdminBriefView($nodal_admin_id)
    {

        $nodal_admin = \Models\StateNodal::with([
            'user'])
            ->find($nodal_admin_id);

        $this->data['nodal_admin'] = $nodal_admin;

        $this->data['state'] = 'Data';

        return view('admin::state.nodal-admin-brief-view', $this->data);
    }

    public function getSchoolBriefView($school_id)
    {

        $this->data['state'] = 'Data';

        return view('admin::state.school-brief-view', $this->data);
    }

    public function getStateSingleView($state_slug)
    {

        $this->data['title'] = 'State';

        $breadcrumb['All States'] = route('admin.state.get');
        $breadcrumb['States'] = route('admin.state.single', $state_slug);

        $state = State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->where('slug', $state_slug)->first();

        $this->data['breadcrumbs'] = [
            $state->name => url('admin/states/' . $state->slug),
        ];

        return view('admin::state.state-single-view', $this->data);
    }

    // Disctrict

    public function getDistrictView($state)
    {

        $this->data['title'] = 'Districts';

        return view('admin::state.districts', $this->data);
    }

    public function getDistrictAdminView($district_id)
    {

        $district = \Models\District::with([
            'districtadmin.user'])
            ->find($district_id);

        $state = State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($district->state_id);

        $this->data['state'] = $state;

        $this->data['district'] = $district;

        $this->data['title'] = 'District Admin';

        return view('admin::state.district-admin', $this->data);
    }

    public function getDistrictNodalView($state)
    {

        $this->data['title'] = 'Districts';

        return view('admin::state.nodal-districts', $this->data);
    }

    public function getDeactivatedDistrictAdminView($district_id)
    {

        $district = \Models\District::with([
            'districtadmin.user'])
            ->find($district_id);

        $state = State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($district->state_id);

        $this->data['state'] = $state;

        $this->data['district'] = $district;

        $this->data['title'] = 'District Admin';

        return view('admin::state.deactivated-district-admin', $this->data);
    }

    // Nodal

    public function getNodalView($district_id)
    {

        $district = \Models\District::with([
            'districtadmin.user'])
            ->find($district_id);

        $state = State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($district->state_id);

        $this->data['state'] = $state;

        $this->data['district'] = $district;

        $this->data['title'] = 'List of Nodal Admins';

        return view('admin::state.nodal-admin', $this->data);
    }

    public function getDeactivatedNodalView($district_id)
    {

        $district = \Models\District::with([
            'districtadmin.user'])
            ->find($district_id);

        $state = State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($district->state_id);

        $this->data['state'] = $state;

        $this->data['district'] = $district;

        $this->data['title'] = 'List of Nodal Admins';

        return view('admin::state.deactivated-nodal-admin', $this->data);
    }

    // School

    public function getSchoolView($state)
    {

        $this->data['title'] = "Admin | Schools";

        return view('admin::school.viewschool', $this->data);
    }

    public function getSchoolAddView($state)
    {

        $this->data['title'] = "Admin | Schools";

        return view('admin::school.add-school', $this->data);
    }

    public function getSchoolSingleView($id)
    {

        $this->data['school'] = School::with(['schooladmin.user', 'language'])->find($id);

        return view('admin::school.viewsingleschool', $this->data);
    }

    // Student

    public function getAllottedStudentView($state)
    {

        $this->data['title'] = "Admin | Students";

        return view('admin::student.allotted-students', $this->data);
    }

    public function getRejectedStudentView($state)
    {

        $this->data['title'] = "Admin | Students";

        return view('admin::student.rejected-students', $this->data);
    }

    public function getEnrolledStudentView($state)
    {

        $this->data['title'] = "Admin | Students";

        return view('admin::student.enrolled-students', $this->data);
    }

    public function getAddLocalitiesView()
    {

        $this->data['title'] = "Manage Districts";

        return view('admin::state.add-localities', $this->data);
    }

    public function getManagementView()
    {

        $this->data['title'] = "Management";

        return view('admin::state.management', $this->data);
    }

    public function getAddBlocksView()
    {

        $this->data['title'] = "Admin | Add Blocks";

        return view('admin::state.add-blocks', $this->data);
    }

    public function getDownloadsView()
    {

        $this->data['title'] = "Downloads | Add Blocks";

        return view('admin::state.download-data', $this->data);
    }

}