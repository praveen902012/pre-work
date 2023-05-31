<?php
namespace Redlof\RoleStateAdmin\Controllers\Message;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class MessageViewController extends RoleStateAdminBaseController {

	public function getStudentMessageView() {

		$this->data['title'] = "Student Message";

		return view('stateadmin::message.students', $this->data);

	}

}
