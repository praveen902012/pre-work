<?php
namespace Redlof\RoleNodalAdmin\Controllers\Student;
use Illuminate\Support\Facades\DB;
use Redlof\RoleNodalAdmin\Controllers\Role\RoleNodalAdminBaseController;

class StudentViewController extends RoleNodalAdminBaseController {

	function __construct() {
		parent::__construct();
	}

	function getRegisteredStudentsView() {

		$this->data['title'] = 'District';

		return view('nodaladmin::student.registered-students', $this->data);
	}

	function getAllStudentsView() {

		$this->data['title'] = 'All Students';

		return view('nodaladmin::student.students', $this->data);
	}

	function getAllotedStudentsView() {

		$this->data['title'] = 'Allotted Students';

		return view('nodaladmin::student.allotted-students', $this->data);
	}

	function getEnrolledStudentsView() {

		$this->data['title'] = 'Enrolled Students';

		return view('nodaladmin::student.enrolled-students', $this->data);
	}

	function getRejectedStudentsView() {

		$this->data['title'] = 'Rejected Students';

		return view('nodaladmin::student.rejected-students', $this->data);
	}

	function getVerifiedStudentsView() {

		$this->data['title'] = 'Verified Students';

		return view('nodaladmin::student.verified-students', $this->data);
	}

	function getAllRejectedStudentsView() {

		$this->data['title'] = 'All Rejected Students';

		return view('nodaladmin::student.all-rejected-students', $this->data);
	}

	function getDropoutPendingView() {

		$this->data['title'] = 'Dropout List';

		return view('nodaladmin::student.dropout-pending-students', $this->data);
	}

	function getDropoutStudentsView() {

		$this->data['title'] = 'Dropout List';

		return view('nodaladmin::student.dropout-students', $this->data);
	}

	function getStudentDetailsView($registration_id) {

		$this->data['title'] = "Student Details";

		$check = \Models\RegistrationCycle::where('registration_id', $registration_id)->first();

		if ($check->status == 'applied' || $check->status == 'withdraw' || $check->status == 'dropout' || $check->status == 'enrolled' || $check->status == 'allotted' || $check->status == 'dismissed' || $check->status == 'rejected') {

			$student = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name', 'last_name', 'mobile', 'email', 'gender', 'dob', 'level_id', 'state_id', 'rejected_document', 'rejected_reason')
				->where('id', $registration_id)
				->with(['statename', 'level', 'personal_details', 'personal_details.subsublocality', 'personal_details.sublocality', 'personal_details.locality', 'personal_details.district', 'personal_details.block', 'parent_details', 'dropout_reason', 'registration_cycle', 'registration_cycle.school'])
				->first();
			
			$certificate_det = DB::table('registration_personal_details')->select("certificate_details")->where("registration_id","=",$registration_id)->first();
			
			$student['certificate_details'] = json_decode($certificate_det->certificate_details);
			
			$this->data['student'] = $student;

			$candidate = \Models\RegistrationBasicDetail::where('id', $registration_id)
				->with('personal_details', 'level', 'parent_details', 'personal_details', 'personal_details.locality', 'personal_details.block', 'personal_details.subsublocality', 'registration_cycle')
				->first();

			$schoolData = [];
			$schoolNearbyData = [];

			if ($candidate->registration_cycle->preferences) {

				foreach ($candidate->registration_cycle->preferences as $key => $value) {
	
					$school = \Models\School::select('id', 'name', 'udise', 'address', 'phone' )
						->where('id', $value)
						->first();
	
					if (!empty($school)) {
	
						$schoolEntry = [];
						$schoolEntry['id'] = $value;
						$schoolEntry['name'] = $school->name;
						$schoolEntry['udise'] = $school->udise;
						$schoolEntry['address'] = $school->address;
						$schoolEntry['phone'] = $school->phone;
	
						array_push($schoolData, $schoolEntry);
					}
				}
			}
			
			if ($candidate->registration_cycle->nearby_preferences) {
	
				foreach ($candidate->registration_cycle->nearby_preferences as $key => $value) {
	
					$school = \Models\School::select('id', 'name', 'udise', 'address', 'phone' )
						->where('id', $value)
						->first();
	
					if (!empty($school)) {
	
						$schoolEntry = [];
						$schoolEntry['id'] = $value;
						$schoolEntry['name'] = $school->name;
						$schoolEntry['udise'] = $school->udise;
						$schoolEntry['address'] = $school->address;
						$schoolEntry['phone'] = $school->phone;
	
						array_push($schoolNearbyData, $schoolEntry);
					}
				}
			}

			$this->data['candidate'] = $candidate;
	
			$this->data['schoolData'] = $schoolData;
	
			$this->data['schoolNearbyData'] = $schoolNearbyData;

			return view('nodaladmin::student.student-details', $this->data);

		} else {

			return view('nodaladmin::student.dropout-pending-students', $this->data);
		}
	}

	function getStudentsVerificationView(){
		$this->data['title'] = 'Verify Students Documents';

		return view('nodaladmin::student.student-doc-verify', $this->data);
	}

	function getStudentsDocVerified(){
		$this->data['title'] = 'Verifed Students Documents';

		return view('nodaladmin::student.student-doc-verifed', $this->data);
	}
	
	function getStudentsDocRejected(){
		$this->data['title'] = 'Rejected Students Documents';

		return view('nodaladmin::student.student-doc-rejected', $this->data);
	}
	

}