<?php
namespace Redlof\RoleStateAdmin\Controllers\Message;
use Illuminate\Http\Request;
use Redlof\Core\Jobs\SendMessages;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class MessageController extends RoleStateAdminBaseController {

	public function postSendStudentMessage(Request $request) {

		$students = \Models\RegistrationBasicDetail::select('id', 'mobile', 'first_name', 'last_name', 'registration_no')
			->where('state_id', $this->state_id)
			->whereHas('registration_cycle', function ($query) use ($request) {
				$query->where('status', $request->student_type);
			})
			->with('registration_cycle', 'registration_cycle.school')
			->get();

		SendMessages::dispatch($students, $request->message);

		return api('Message Sent Successfully');
	}

}
