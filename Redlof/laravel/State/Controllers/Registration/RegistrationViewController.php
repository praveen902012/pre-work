<?php

namespace Redlof\State\Controllers\Registration;

use Exceptions\EntityNotFoundException;
use Exceptions\UnAuthorizedException;
use Illuminate\Http\Request;
use Redlof\State\Controllers\StateBaseController;

class RegistrationViewController extends StateBaseController
{

	function __construct()
	{
		parent::__construct();
	}

	function getRegistrationPage()
	{

		if ($this->data['state']['student_registration']) {

			$this->data['title'] = "Personal details";

			\Helpers\RegistrationAccessHelperClass::cycleCheck($this->state);

			return view('state::registration.student-personal', $this->data);
		}

		throw new EntityNotFoundException("Student Registration Process Is Closed.");
	}

	function getRegistrationParentPage($state, $registration_id, Request $request)
	{

		$this->data['registration'] = \Models\RegistrationBasicDetail::select('id', 'state', 'status')->where('registration_no', $registration_id)->with(['personal_details', 'registration_cycle'])->first();

		\Helpers\RegistrationAccessHelperClass::checkAccess($this->data['registration'], 'step2', $this->state);

		$this->data['medical_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');
		$this->data['caste_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');
		$this->data['income_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');
		$this->data['orphan_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');
		$this->data['kodh_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');
		$this->data['disable_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');
		$this->data['single_women_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');

		$this->data['title'] = "Parent details";

		$this->data['show_preview'] = FALSE;

		if ($this->data['registration']->registration_cycle) {
			$this->data['show_preview'] = TRUE;
		}

		$this->data['registration_no'] = $this->validateStudentSession($request, $registration_id);

		return view('state::registration.student-parent', $this->data);
	}

	function getRegistrationAddressPage($state, $registration_id, Request $request)
	{

		$this->data['registration'] = \Models\RegistrationBasicDetail::select('id', 'state', 'status', 'state_id', 'registration_no')->where('registration_no', $registration_id)->with(['personal_details', 'registration_cycle'])->first();

		\Helpers\RegistrationAccessHelperClass::checkAccess($this->data['registration'], 'step3', $this->state);

		$this->data['title'] = "Address details";

		$this->data['show_preview'] = FALSE;

		if ($this->data['registration']->registration_cycle) {
			$this->data['show_preview'] = TRUE;
		}

		$this->data['registration_no'] = $this->validateStudentSession($request, $registration_id);

		return view('state::registration.student-address', $this->data);
	}

	function getRegistrationFilesPage($state, $registration_id, Request $request)
	{

		$this->data['title'] = "Document details";

		$this->data['registration'] = \Models\RegistrationBasicDetail::select('id', 'state', 'status', 'aadhar_no', 'state_id', 'registration_no')->where('registration_no', $registration_id)->with(['personal_details', 'registration_cycle'])->first();

		\Helpers\RegistrationAccessHelperClass::checkAccess($this->data['registration'], 'step4', $this->state);

		$this->data['candidate'] = \Models\RegistrationPersonalDetail::select('id', 'certificate_details', 'address_proof', 'registration_id', 'category')
			->with('parent_details')
			->whereHas('basic_details', function ($query) use ($registration_id) {
				$query->where('registration_no', $registration_id);
			})->first();

		$this->data['medical_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');
		$this->data['caste_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');
		$this->data['income_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');
		$this->data['orphan_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');
		$this->data['kodh_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');
		$this->data['disable_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');
		$this->data['single_women_certificate'] = \AWSHelper::getSignedUrl('students/caste-certificate.jpeg.jpeg');

		// $parentDetails = \Models\RegistrationParentDetail::select('parent_type')
		// 	->whereHas('basic_details', function ($query) use ($registration_no) {
		// 		$query->where('registration_no', $registration_no);
		// 	})
		// 	->get();

		$this->data['show_preview'] = FALSE;

		if ($this->data['registration']->registration_cycle) {
			$this->data['show_preview'] = TRUE;
		}

		$this->data['registration_no'] = $this->validateStudentSession($request, $registration_id);

		return view('state::registration.student-document', $this->data);
	}

	function getRegistrationSchoolsPage($state, $registration_id, Request $request)
	{

		$this->data['registration'] = \Models\RegistrationBasicDetail::select('id', 'state', 'status', 'state_id', 'registration_no')
			->where('registration_no', $registration_id)
			->with(['registration_cycle'])->first();

		\Helpers\RegistrationAccessHelperClass::checkAccess($this->data['registration'], 'step5', $this->state);

		$this->data['title'] = "School selection details";

		$this->data['candidate'] = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name', 'middle_name', 'last_name', 'registration_no')->where('registration_no', $registration_id)->with(['personal_details', 'parent_details'])->first();

		$this->data['registration_no'] = $this->validateStudentSession($request, $registration_id);

		$this->data['show_preview'] = FALSE;

		if ($this->data['registration']->registration_cycle) {
			$this->data['show_preview'] = TRUE;
		}

		return view('state::registration.student-school-selection', $this->data);
	}

	function getRegistrationUpdatePage($state, $registration_id, Request $request)
	{

		$this->data['registration'] = \Models\RegistrationBasicDetail::select('id', 'state', 'status', 'registration_no')->where('registration_no', $registration_id)->with(['personal_details', 'registration_cycle'])->first();

		\Helpers\RegistrationAccessHelperClass::checkAccess($this->data['registration'], 'step1', $this->state);

		$this->data['title'] = "Personal details";

		$this->data['show_preview'] = FALSE;

		if ($this->data['registration']->registration_cycle) {
			$this->data['show_preview'] = TRUE;
		}

		$this->data['registration_no'] = $this->validateStudentSession($request, $registration_id);

		return view('state::registration.student-personal-update', $this->data);
	}

	function getRegistrationPreviewPage($state, $registration_id, Request $request)
	{

		if (!$this->state->student_registration) {

			throw new UnAuthorizedException("Currently there is no ongoing registration open");
		}

		$candidate = \Models\RegistrationBasicDetail::where('registration_no', $registration_id)
			->with('personal_details', 'level', 'parent_details', 'personal_details', 'personal_details.locality', 'personal_details.block', 'personal_details.subsublocality', 'registration_cycle')
			->first();

		$this->data['show_preview'] = FALSE;

		if ($candidate->registration_cycle) {
			$this->data['show_preview'] = TRUE;
		}

		$personal_details = \Models\RegistrationPersonalDetail::where('registration_id', $candidate->id)
			->first();

		$bank_details = \Models\RegistrationBankDetail::where('registration_id', $candidate->id)
			->first();

		$this->data['disable_category'] = false;

		if ($candidate->age_relaxation == 'applicable') {

			$this->data['disable_category'] = true;
		}

		$schoolData = [];
		$schoolNearbyData = [];

		if ($candidate->registration_cycle->preferences) {

			foreach ($candidate->registration_cycle->preferences as $key => $value) {

				$school = \Models\School::select('id', 'name', 'udise')
					->where('id', $value)
					->first();

				if (!empty($school)) {

					$schoolEntry = [];
					$schoolEntry['id'] = $value;
					$schoolEntry['name'] = $school->name;
					$schoolEntry['udise'] = $school->udise;

					array_push($schoolData, $schoolEntry);
				}
			}
		}
		if ($candidate->registration_cycle->nearby_preferences) {

			foreach ($candidate->registration_cycle->nearby_preferences as $key => $value) {

				$school = \Models\School::select('id', 'name', 'udise')
					->where('id', $value)
					->first();

				if (!empty($school)) {

					$schoolEntry = [];
					$schoolEntry['id'] = $value;
					$schoolEntry['name'] = $school->name;
					$schoolEntry['udise'] = $school->udise;

					array_push($schoolNearbyData, $schoolEntry);
				}
			}
		}

		$this->data['registration'] = $candidate;

		$this->data['candidate'] = $candidate;

		$this->data['schoolData'] = $schoolData;

		$this->data['personal_details'] = $personal_details;

		$this->data['bank_details'] = $bank_details;

		$this->data['schoolNearbyData'] = $schoolNearbyData;

		$this->data['title'] = "Preview registration";

		$this->data['registration_no'] = $this->validateStudentSession($request, $registration_id);

		return view('state::registration.preview-registration', $this->data);
	}

	function getRegistrationSuccessPage($state, $registration_id, Request $request)
	{
		$this->data['title'] = "Successful registration";

		$this->data['registration_no'] = $this->validateStudentSession($request, $registration_id);

		return view('state::registration.success-registration', $this->data);
	}

	function getRegistrationResultPage($state, $registration_id)
	{
		$this->data['title'] = "Registration result";

		$now = \Carbon::now();

		$this->data['registration_no'] = $registration_id;

		$this->data['registration'] = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name', 'middle_name', 'last_name', 'level_id', 'dob', 'status')
			->with(['level', 'registration_cycle.application_details', 'registration_cycle.school'])
			->where('registration_no', $registration_id)
			// ->where('status', 'completed')
			->first();

		if (count($this->data['registration']) == 0) {
			throw new EntityNotFoundException("Please complete your application to view your application status");
		}

		if (empty($this->data['registration']['registration_cycle'])) {
			throw new EntityNotFoundException("Please complete your application to view your application status");
		}

		$this->data['check'] = \Models\ApplicationCycle::where('state_id', $this->state->id)
			->where('status', 'new')
			->where('session_year', $this->data['registration']['registration_cycle']['application_details']['session_year'])
			->where('cycle', $this->data['registration']['registration_cycle']['application_details']['cycle'])
			->where('stu_reg_start_date', '<', $now)
			->where('stu_reg_end_date', '>', $now)
			->get();

		$lottery_status = \Models\ApplicationCycle::where('state_id', $this->state->id)
			->where('status', 'completed')
			->where('session_year', $this->data['registration']['registration_cycle']['application_details']['session_year'])
			->where('cycle', $this->data['registration']['registration_cycle']['application_details']['cycle'])
			->get();

		if($lottery_status->isNotEmpty()){

			$this->data['lottery_triggered'] = true;

		}else{

			$this->data['lottery_triggered'] = false;
		}

		return view('state::registration.result-registration', $this->data);
	}

	function getRegistrationForm($state, $registration_id)
	{

		$this->data['title'] = "Registration form";

		$this->data['registration_no'] = $registration_id;

		$candidate = \Models\RegistrationBasicDetail::where('registration_no', $registration_id)
			->with('personal_details', 'level', 'parent_details', 'personal_details', 'personal_details.locality', 'personal_details.block', 'personal_details.subsublocality', 'registration_cycle')
			->first();

		$schoolData = [];
		$schoolNearbyData = [];

		if ($candidate->registration_cycle->preferences) {

			foreach ($candidate->registration_cycle->preferences as $key => $value) {

				$school = \Models\School::select('id', 'name', 'udise')
					->where('id', $value)
					->first();

				$schoolEntry = [];
				$schoolEntry['id'] = $value;
				$schoolEntry['name'] = $school->name;
				$schoolEntry['udise'] = $school->udise;

				array_push($schoolData, $schoolEntry);
			}
		}
		if ($candidate->registration_cycle->nearby_preferences) {

			foreach ($candidate->registration_cycle->nearby_preferences as $key => $value) {

				$school = \Models\School::select('id', 'name', 'udise')
					->where('id', $value)
					->first();

				$schoolEntry = [];
				$schoolEntry['id'] = $value;
				$schoolEntry['name'] = $school->name;
				$schoolEntry['udise'] = $school->udise;

				array_push($schoolNearbyData, $schoolEntry);
			}
		}

		$data['schoolData'] = $schoolData;

		$data['schoolNearbyData'] = $schoolNearbyData;

		$this->data['candidate'] = $candidate;

		return view('state::registration.registration-form', $this->data);
	}

	function getLogoutView(Request $request, $state, $registration_no)
	{

		$request->session()->forget('registration_no');

		return redirect()->route('state', [$state]);
	}

	public function validateStudentSession(Request $request, $registration_no)
	{

		if ($request->session()->has('registration_no')) {
			$stored_registration_no = $request->session()->get('registration_no');

			if ($registration_no != $stored_registration_no) {

				$request->session()->pull('registration_no');

				throw new UnAuthorizedException("Session validation error");
			}

			return $stored_registration_no;
		} else {
			throw new UnAuthorizedException("Session error");
		}
	}
}