<?php
namespace Redlof\RoleNodalAdmin\Controllers\Role;

use Redlof\RoleNodalAdmin\Controllers\Role\RoleNodalAdminBaseController;

class RoleNodalAdminViewController extends RoleNodalAdminBaseController
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

        return view('nodaladmin::role.dashboard', $this->data);
    }

    public function getProfileView()
    {
        $this->data['title'] = "Profile";
        return view('nodaladmin::role.profile', $this->data);
    }

    public function getProfileUpdateView()
    {
        $this->data['title'] = "Update Profile";
        return view('nodaladmin::role.update-profile', $this->data);
    }

    public function getProfileUpdatePhotoView()
    {
        $this->data['title'] = "Photo";
        return view('nodaladmin::role.update-photo', $this->data);
    }

    public function getChangePasswordView()
    {
        $this->data['title'] = "Change Password";
        return view('nodaladmin::role.change-password', $this->data);
    }

    public function getUploadUdiseView()
    {

        if ($this->data['udise_requested']) {

            $this->data['title'] = "Upload Udise";
            return view('nodaladmin::role.upload-udise', $this->data);

        } else {

            $this->data['title'] = "Dashboard";
            return view('nodaladmin::role.dashboard', $this->data);

        }

    }

    public function getPendingUdiseView()
    {

        if ($this->data['udise_requested']) {

            $this->data['title'] = "Upload Udise";
            return view('nodaladmin::role.pending-upload-udise', $this->data);

        } else {

            $this->data['title'] = "Dashboard";
            return view('nodaladmin::role.dashboard', $this->data);

        }

    }

}
