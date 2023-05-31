<?php
namespace Redlof\RoleStateAdmin\Controllers\Schoolmanagement;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class SchoolManagementController extends RoleStateAdminBaseController {

	public function getschoolmanagementView() {

		return view('stateadmin::school-management.school-management', $this->data);
	}


}