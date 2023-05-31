<?php
namespace Redlof\RoleDistrictAdmin\Controllers\Role;

use Models\NodalRequest;
use Models\UdiseNodal;
use Redlof\RoleDistrictAdmin\Controllers\Role\RoleDistrictAdminBaseController;

class RoleDistrictAdminViewController extends RoleDistrictAdminBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDashboardView()
    {
        $this->data['title'] = "Dashboard";
        // $now = \Carbon::now();
        // $current_cycle = $now->year;

        $this->data['current_cycle'] = $this->data['latest_application_cycle']->session_year;

        return view('districtadmin::role.dashboard', $this->data);
    }

    public function getProfileView()
    {
        $this->data['title'] = "Profile";
        return view('districtadmin::role.profile', $this->data);
    }

    public function getChangePasswordView()
    {
        $this->data['title'] = "Change Password";
        return view('districtadmin::role.change-password', $this->data);
    }

    public function getProfileUpdateView()
    {
        $this->data['title'] = "Update Profile";
        return view('districtadmin::role.update-profile', $this->data);
    }

    public function getProfileUpdatePhotoView()
    {
        $this->data['title'] = "Photo";
        return view('districtadmin::role.update-photo', $this->data);
    }

    public function getNodalView()
    {

        $state = \Models\State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($this->data['district']->state_id);

        $this->data['state'] = $state;

        $this->data['title'] = 'List of Nodal Admins';

        return view('districtadmin::nodal.nodal-admin', $this->data);
    }

    public function getBulkView()
    {

        $this->data['udise_added'] = false;

        $this->data['nodal_requested'] = false;

        $check_nodal_request = NodalRequest::where('district_id', $this->district->id)->first();

        if (isset($check_nodal_request)) {

            $this->data['nodal_requested'] = true;

        } else {

            $check_udise_nodal = UdiseNodal::where('district_id', $this->district->id)->count();

            if ($check_udise_nodal > 0) {

                $this->data['udise_added'] = true;

            }

        }

        $this->data['title'] = 'Bulk Upload';

        return view('districtadmin::nodal.bulk-upload', $this->data);
    }

    public function getNodalAdminBriefView($nodal_admin_id)
    {

        $nodal_admin = \Models\StateNodal::with(['user', 'assigned_nodal'])
            ->find($nodal_admin_id);

        $this->data['nodal_admin'] = $nodal_admin;

        $this->data['state'] = 'Data';

        return view('districtadmin::nodal.nodal-admin-brief-view', $this->data);
    }

    public function getDeactivatedNodalView($district_id)
    {

        $district = \Models\District::with([
            'districtadmin.user'])
            ->find($district_id);

        $state = \Models\State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($district->state_id);

        $this->data['state'] = $state;

        $this->data['district'] = $district;

        $this->data['title'] = 'List of Nodal Admins';

        return view('districtadmin::nodal.deactivated-nodal-admin', $this->data);
    }

    public function getDeactivatedNodals(Request $request, $district_id)
    {

        $statenodal = \Models\StateNodal::where('status', 'inactive')
            ->where('district_id', $district_id)
            ->with(['user', 'state'])
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $statenodal);
    }

}
