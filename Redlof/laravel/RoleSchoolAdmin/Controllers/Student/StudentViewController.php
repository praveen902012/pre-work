<?php
namespace Redlof\RoleSchoolAdmin\Controllers\Student;
use Redlof\RoleSchoolAdmin\Controllers\Role\RoleSchoolAdminBaseController;

class StudentViewController extends RoleSchoolAdminBaseController {

	public function getAllStudentsView() {

		$this->data['title'] = "All Students";
		return view('schooladmin::student.students', $this->data);
	}

	public function getAllottedStudentsView() {

		$this->data['title'] = "Allotted Students";
		return view('schooladmin::student.allotted-students', $this->data);
	}

	public function getEnrolledStudentsView() {
		$this->data['title'] = "Enrolled Students";
		return view('schooladmin::student.enrolled-students', $this->data);
	}

	public function getAddSubjectView() {
		$this->data['title'] = "Add Subject";
		return view('schooladmin::student.add-subject', $this->data);
	}

	public function getRejectedStudentsView() {
		$this->data['title'] = "Rejected Students";
		return view('schooladmin::student.rejected-students', $this->data);
	}

	public function getDroppedStudentsView() {
		$this->data['title'] = "Dropout Students";
		return view('schooladmin::student.dropout-students', $this->data);
	}

	public function getAttendanceView() {
		$this->data['title'] = "Attendance List";
		return view('schooladmin::student.attendance', $this->data);
	}

	public function getGradeView() {
		$this->data['title'] = "Grades List";
		return view('schooladmin::student.grades', $this->data);
	}

	public function getAddAttendanceView($student_id) {

		$student = \Models\RegistrationBasicDetail::where('id', $student_id)

			->with(['registration_cycle', 'level'])

			->whereHas('registration_cycle', function ($subQuery) {

				$subQuery->where('status', 'enrolled')
					->where('allotted_school_id', $this->school->id)
					->from(with(new \Models\RegistrationCycle)->getTable());
			})

			->first();

		if ($student) {

			$this->data['student'] = $student;

			$this->data['title'] = "Student Attendance";
			return view('schooladmin::student.add-attendance', $this->data);

		} else {

			$this->data['title'] = "Attendance List";
			return view('schooladmin::student.attendance', $this->data);

		}
	}

	public function getAddGradeView($student_id) {

		$student = \Models\RegistrationBasicDetail::where('id', $student_id)

			->with(['registration_cycle', 'level'])

			->whereHas('registration_cycle', function ($subQuery) {

				$subQuery->where('status', 'enrolled')
					->where('allotted_school_id', $this->school->id)
					->from(with(new \Models\RegistrationCycle)->getTable());
			})

			->first();

		if ($student) {

			$this->data['student'] = $student;

			$this->data['title'] = "Student Grades";
			return view('schooladmin::student.add-grade', $this->data);

		} else {

			$this->data['title'] = "Grades List";
			return view('schooladmin::student.grades', $this->data);

		}
	}

	public function getStudentDetailsView($registration_id) {

		$this->data['title'] = "Student Details";
		$check = \Models\RegistrationCycle::where('registration_id', $registration_id)->first();

		$student = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name', 'last_name', 'mobile', 'email', 'gender', 'dob', 'level_id', 'state_id')
			->where('id', $registration_id)
			->with(['statename', 'level', 'personal_details', 'personal_details.subsublocality', 'personal_details.sublocality', 'personal_details.locality', 'personal_details.district', 'personal_details.block', 'parent_details', 'registration_cycle', 'bank_details', 'report_card', 'report_card.grade_report', 'report_card.grade_report.subject', 'report_card.attendance_report'])
			->first();

		$this->data['student'] = $student;

		return view('schooladmin::student.student-details', $this->data);
	}

}