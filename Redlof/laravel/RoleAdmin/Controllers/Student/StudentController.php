<?php
namespace Redlof\RoleAdmin\Controllers\Student;
use Illuminate\Http\Request;
use Redlof\RoleAdmin\Controllers\State\StateBaseController;

class StudentController extends StateBaseController {

	public function __construct() {

		parent::__construct();
	}

	function getSearchStudents(Request $request, $state_id) {

		$students = \Models\RegistrationBasicDetail::where('state_id', $state_id)
			->where('status', 'completed')
			->where('first_name', 'ilike', '%' . $request['s'] . '%')
			->page($request)
			->orderBy('created_at', 'desc')
			->get()
			->preparePage($request);

		return api('', $students);
	}

}