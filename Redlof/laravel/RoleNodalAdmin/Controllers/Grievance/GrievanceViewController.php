<?php
namespace Redlof\RoleNodalAdmin\Controllers\Grievance;

use Redlof\RoleNodalAdmin\Controllers\Role\RoleNodalAdminBaseController;

class GrievanceViewController extends RoleNodalAdminBaseController {

	function __construct() {
		parent::__construct();
	}

	function getAdmissionDeniedView() {

		$this->data['title'] = 'Admission Denied';

		return view('nodaladmin::grievance.admission-denied', $this->data);
	}

}