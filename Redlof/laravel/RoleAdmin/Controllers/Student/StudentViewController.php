<?php
namespace Redlof\RoleAdmin\Controllers\Student;

use Redlof\RoleAdmin\Controllers\State\StateBaseController;

class StudentViewController extends StateBaseController {

	public function getStudents() {

		$this->data['title'] = "Admin | Students";

		return view('admin::student.allotted-students', $this->data);
	}

}