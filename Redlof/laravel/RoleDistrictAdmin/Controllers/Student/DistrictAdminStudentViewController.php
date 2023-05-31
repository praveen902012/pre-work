<?php
namespace Redlof\RoleDistrictAdmin\Controllers\Student;
use Redlof\RoleDistrictAdmin\Controllers\Role\RoleDistrictAdminBaseController;
use Redlof\RoleDistrictAdmin\Controllers\Student\DistrictAdminStudentViewController;

class DistrictAdminStudentViewController extends RoleDistrictAdminBaseController {


	public function getAllStudentsView() {

		$this->data['title'] = 'All Students | District';

		$now = \Carbon::now();

		$current_cycle = $now->year;

		$this->data['current_cycle'] = $current_cycle;

		return view('districtadmin::student.students', $this->data);
	}

	public function getRegisteredStudentsView() {

		$this->data['title'] = 'Registered student';

		$now = \Carbon::now();

		$current_cycle = $now->year;

		$this->data['current_cycle'] = $current_cycle;

		return view('districtadmin::student.registered-students', $this->data);
	}

	public function getAllotedStudentsView() {

		$this->data['title'] = 'Alloted students';

		$now = \Carbon::now();

		$current_cycle = $now->year;

		$this->data['current_cycle'] = $current_cycle;

		return view('districtadmin::student.allotted-students', $this->data);
	}

	public function getEnrolledStudentsView() {

		$this->data['title'] = 'Enrolled Student';

		$now = \Carbon::now();

		$current_cycle = $now->year;

		$this->data['current_cycle'] = $current_cycle;
		
		return view('districtadmin::student.enrolled-students', $this->data);
	}

	public function getStudentDetailsView($registration_no) {

		$student = \Models\RegistrationBasicDetail::where('registration_no', $registration_no)
			->with('personal_details', 'level', 'parent_details', 'personal_details', 'country_state', 'personal_details.district', 'personal_details.locality', 'personal_details.block', 'personal_details.subsublocality', 'registration_cycle')
			->first();

		$this->data['student'] = $student;

		$schoolData = [];
		$nearbySchoolData = [];

		if ($student->registration_cycle) {

			if ($student->registration_cycle->preferences) {

				foreach ($student->registration_cycle->preferences as $key => $value) {

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

			if (isset($student->registration_cycle->nearby_preferences)) {

				foreach ($student->registration_cycle->nearby_preferences as $key => $value) {

					$school = \Models\School::select('id', 'name', 'udise')
						->where('id', $value)
						->first();

					$schoolEntry = [];
					$schoolEntry['id'] = $value;
					$schoolEntry['name'] = $school->name;
					$schoolEntry['udise'] = $school->udise;

					array_push($nearbySchoolData, $schoolEntry);

				}
			}
		}

		$this->data['schoolData'] = $schoolData;

		$this->data['nearbySchoolData'] = $nearbySchoolData;
		
		$this->data['title'] = 'Student Details';

		return view('districtadmin::student.student-details', $this->data);

	}

	public function getStudentReportsView() {

		$this->data['title'] = 'Student School Reports';

		return view('districtadmin::student.student-reports', $this->data);

	}

	public function getStudentSuspiciousView() {

		$this->data['title'] = 'Suspicious Registrations';

		return view('districtadmin::student.student-suspicious', $this->data);

	}

	public function getAdmissionDeniedView() {

		$this->data['title'] = 'Admission Denied';

		return view('districtadmin::student.admission-denied', $this->data);

	}

}