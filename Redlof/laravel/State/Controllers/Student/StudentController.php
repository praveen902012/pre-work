<?php
namespace Redlof\State\Controllers\Student;

use Illuminate\Http\Request;
use Redlof\Core\Controllers\Controller;
use Exceptions\ValidationFailedException;
class StudentController extends Controller {

	public function getRegisteredStudent(Request $request, $state_id, $selected_cycle) {

		if ($selected_cycle == 'null') {
			$now = \Carbon::now();
			$selected_cycle = $now->year;
		}

		$students = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name')
			->where('state_id', $state_id)
			->whereHas('registration_cycle_unique.application_details', function ($query) use ($selected_cycle) {
				$query->where('session_year', $selected_cycle);
			})
			->page($request)
			->get()
			->preparePage($request);

		return api('', $students);
	}

	public function getAllottedStudent(Request $request, $state_id, $selected_cycle) {

		if ($selected_cycle == 'null') {
			$now = \Carbon::now();
			$application_year = $now->year;
		}

		$registration_id = \Models\RegistrationCycle::where('status', 'allotted')
			->get()
			->pluck('registration_id');

		$students = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name')
			->whereIn('id', $registration_id)
			->where('state_id', $state_id)
			->whereHas('registration_cycle_unique.application_details', function ($query) use ($selected_cycle) {
				$query->where('session_year', $selected_cycle);
			})
			->page($request)
			->get()
			->preparePage($request);

		return api('', $students);
	}

	public function getEnrolledStudent(Request $request, $state_id, $selected_cycle) {

		if ($selected_cycle == 'null') {
			$now = \Carbon::now();
			$selected_cycle = $now->year;
		}

		$registration_id = \Models\RegistrationCycle::where('status', 'enrolled')
			->get()
			->pluck('registration_id');

		$students = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name')
			->whereIn('id', $registration_id)
			->where('state_id', $state_id)
			->whereHas('registration_cycle_unique.application_details', function ($query) use ($selected_cycle) {
				$query->where('session_year', $selected_cycle);
			})
			->page($request)
			->get()
			->preparePage($request);

		return api('', $students);
	}

	public function getRejectedStudent(Request $request, $state_id, $selected_cycle) {

		if ($selected_cycle == 'null') {
			$now = \Carbon::now();
			$selected_cycle = $now->year;
		}

		$registration_id = \Models\RegistrationCycle::where('status', 'rejected')
			->get()
			->pluck('registration_id');

		$registration_id_check = \Models\RegistrationCycle::whereIn('registration_id', $registration_id)
			->where('status', '<>', 'rejected')
			->get()
			->pluck('registration_id');

		$reject_registration_id = array_diff($registration_id->all(), $registration_id_check->all());

		$students = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name')
			->whereIn('id', $reject_registration_id)
			->where('state_id', $state_id)
			->whereHas('registration_cycle_unique.application_details', function ($query) use ($selected_cycle) {
				$query->where('session_year', $selected_cycle);
			})
			->page($request)
			->get()
			->preparePage($request);

		return api('', $students);
	}

	public function searchRegisteredStudent(Request $request, $state_id, $selected_cycle) {

		if ($selected_cycle == 'null') {
			$now = \Carbon::now();
			$selected_cycle = $now->year;
		}

		$students = \Models\RegistrationBasicDetail::whereHas('registration_cycle_unique.application_details', function ($query) use ($selected_cycle) {
			$query->where('session_year', $selected_cycle);
		})
			->search($request, ['registration_no', 'first_name'])
			->select('id', 'registration_no', 'first_name')
			->where('state_id', $state_id)
			->page($request)
			->get()
			->preparePage($request);

		return api('', $students);
	}

	public function getApplicationCycle($state_id) {

		$application_cycle = \Models\ApplicationCycle::select('session_year')
			->where('state_id', $state_id)
			->distinct('session_year')
			->get();

		return api('', $application_cycle);

	}

	public function searchAllottedStudent(Request $request, $state_id, $selected_cycle) {

		if ($selected_cycle == 'null') {
			$now = \Carbon::now();
			$selected_cycle = $now->year;
		}

		$registration_id = \Models\RegistrationCycle::where('status', 'allotted')
			->get()
			->pluck('registration_id');

		$students = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name')
			->whereIn('id', $registration_id)
			->where('state_id', $state_id)
			->whereHas('registration_cycle_unique.application_details', function ($query) use ($selected_cycle) {
				$query->where('session_year', $selected_cycle);
			})
			->search($request, ['registration_no', 'first_name'])
			->page($request)
			->get()
			->preparePage($request);

		return api('', $students);
	}

	public function searchEnrolledStudent(Request $request, $state_id, $selected_cycle) {

		if ($selected_cycle == 'null') {
			$now = \Carbon::now();
			$selected_cycle = $now->year;
		}

		$registration_id = \Models\RegistrationCycle::where('status', 'enrolled')
			->get()
			->pluck('registration_id');

		$students = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name')
			->whereIn('id', $registration_id)
			->where('state_id', $state_id)
			->whereHas('registration_cycle_unique.application_details', function ($query) use ($selected_cycle) {
				$query->where('session_year', $selected_cycle);
			})
			->search($request, ['registration_no', 'first_name'])
			->page($request)
			->get()
			->preparePage($request);

		return api('', $students);
	}

	public function searchRejectedStudent(Request $request, $state_id, $selected_cycle) {

		if ($selected_cycle == 'null') {
			$now = \Carbon::now();
			$selected_cycle = $now->year;
		}

		$registration_id = \Models\RegistrationCycle::where('status', 'rejected')
			->get()
			->pluck('registration_id');

		$students = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name')
			->whereIn('id', $registration_id)
			->where('state_id', $state_id)
			->whereHas('registration_cycle_unique.application_details', function ($query) use ($selected_cycle) {
				$query->where('session_year', $selected_cycle);
			})
			->search($request, ['registration_no', 'first_name'])
			->page($request)
			->get()
			->preparePage($request);

		return api('', $students);
	}
	public function SearchForStudent(Request $request, $state_id)
	{
		$now = \Carbon::now();

		$current_cycle = $now->year;

		$application_cycle = \Models\ApplicationCycle::where('session_year', $current_cycle)->get();

		$application_cycle_id = $application_cycle->pluck('id')->toArray();

		$registration_no = $request['registration'];

		$students = [];
		
		if($registration_no==''){
			throw new \Exceptions\ValidationFailedException("Enter Registration Number");
		}
		
		$students = \Models\RegistrationBasicDetail::where('registration_no',$registration_no)
			->with(['level', 'parent_details', 'registration_cycle_latest', 'registration_cycle_latest.school'])
			->where('state_id', $state_id)
			->whereHas('registration_cycle_latest', function ($query) use($application_cycle_id) {

				$query->whereIn('application_cycle_id', $application_cycle_id);
			})
			->get();

		if(empty(json_decode($students))){
			throw new \Exceptions\ValidationFailedException("No Entries Found");
		}

		return api('', $students);
	}

	public function SearchForStudentByName(Request $request, $state_id)
	{
		$now = \Carbon::now();

		$current_cycle = $now->year;

		$application_cycle = \Models\ApplicationCycle::where('session_year', $current_cycle)->get();

		$application_cycle_id = $application_cycle->pluck('id')->toArray();

		$studob = date('Y-m-d',strtotime(str_replace('/', '-', $request['studob'])));
		
		$parentname = $request['parentname'];
		
		$studentname = $request['firstname'];
		
		if($studentname==''){
			throw new \Exceptions\ValidationFailedException("Enter Student Name");
		}
		
		if($studob == '1970-01-01'){
			throw new \Exceptions\ValidationFailedException("Enter Vaild Date of Birth");
		}

		if($parentname){
			$students = \Models\RegistrationBasicDetail::where('first_name','ilike',$studentname)
			->with(['level', 'parent_details', 'registration_cycle_latest', 'registration_cycle_latest.school'])
			->where('dob',$studob)
			->where('state_id', $state_id)
			->whereHas('parent_details', function ($query) use ($parentname) {
				$query->where('parent_name','ilike', $parentname);
			})
			->whereHas('registration_cycle_latest', function ($query) use($application_cycle_id) {

				$query->whereIn('application_cycle_id', $application_cycle_id);
			})
			->get();
		
		}else{
		
			$students = \Models\RegistrationBasicDetail::where('first_name','ilike',$studentname)
			->with(['level', 'parent_details', 'registration_cycle_latest', 'registration_cycle_latest.school'])
			->where('dob',$studob)
			->where('state_id', $state_id)
			->whereHas('registration_cycle_latest', function ($query) use($application_cycle_id) {

				$query->whereIn('application_cycle_id', $application_cycle_id);
			})
			->get();
		}
		
		if(empty(json_decode($students))){
			throw new \Exceptions\ValidationFailedException("No Entries Found");
		}
		
		return api('', $students);
	}
}