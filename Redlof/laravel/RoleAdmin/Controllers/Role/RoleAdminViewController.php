<?php
namespace Redlof\RoleAdmin\Controllers\Role;
use Redlof\RoleAdmin\Controllers\Role\RoleAdminBaseController;

class RoleAdminViewController extends RoleAdminBaseController {

	function __construct() {
		parent::__construct();
	}

	function getDashboardView() {
		$this->data['title'] = "Dashboard";
		return view('admin::role.dashboard', $this->data);
	}

	function getProfileView() {
		$this->data['title'] = "Profile";
		return view('admin::role.profile', $this->data);
	}

	function getProfileUpdateView() {
		$this->data['title'] = "Update Profile";
		return view('admin::role.update-profile', $this->data);
	}

	function getProfileUpdatePhotoView() {

		$this->data['title'] = "Photo";
		return view('admin::role.update-photo', $this->data);
	}

	function getChangePasswordView() {
		$this->data['title'] = "Change Password";
		return view('admin::role.change-password', $this->data);
	}

}