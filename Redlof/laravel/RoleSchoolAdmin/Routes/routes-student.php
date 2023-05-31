<?php

Route::group(array('prefix' => 'api/schooladmin', 'namespace' => 'Student'), function () {

	$studentapi = 'StudentController@';

	Route::get('get/bankdetail/{ifsc}', $studentapi . 'getBankDetails');

	Route::get('get/class_levels', $studentapi . 'getClassLevels');

	Route::get('get/subjects', $studentapi . 'getSchoolSubjects');

	Route::get('get/check/{registration_id}/allsubjects/{level_id}', $studentapi . 'getAllSchoolSubjects')->where('level_id', '[0-9]+')->where('registration_id', '[0-9]+');

	Route::post('add/attendance', $studentapi . 'postAddAttendance');

	Route::post('add/marks', $studentapi . 'postAddMarks');

	Route::get('get/attendance/{registration_id}', $studentapi . 'getMonthDetails')->where('district_id', '[0-9]+');

	Route::get('get/students/{level_id}', $studentapi . 'getStudentsByClass');

	Route::get('search/students/{level_id}', $studentapi . 'getSearchStudentsByClass');

	Route::post('mark-student/dropout/{registration_id}', $studentapi . 'postMarkStudentDropout')->where('registration_id', '[0-9]+');

	Route::get('get/allotted-students', $studentapi . 'getAllottedStudents');

	Route::get('get/enrolled-students', $studentapi . 'getEnrolledStudents');

	Route::get('get/rejected-students', $studentapi . 'getRejectedStudents');

	Route::post('student/enroll/{registration_id}', 'StudentController@postEnrollStudent')->where('registration_id', '[0-9]+');

	Route::post('student/un-enroll/{registration_id}', 'StudentController@postUnEnrollStudent')->where('registration_id', '[0-9]+');

	Route::post('student/update-bank/{registration_id}', 'StudentController@postUpdateStudentBank')->where('registration_id', '[0-9]+');

	Route::post('student/update-bank-details/{registration_id}', 'StudentController@postUpdateStudentBankDetails')->where('registration_id', '[0-9]+');

	Route::get('get/student/bank-details/{registration_id}', 'StudentController@getStudentBankDetails')->where('registration_id', '[0-9]+');

	Route::post('student/reject', $studentapi . 'postRejectStudent');

	Route::post('subject/add', $studentapi . 'postAddSubject');

	Route::post('subject/delete/{subject_id}', $studentapi . 'postDeleteSubject')->where('subject_id', '[0-9]+');

	Route::get('get/applicationcycle', $studentapi . 'getApplicationCycles');

	Route::get('get/all-students/ac/{cycle}/class/{class}', $studentapi . 'getAllListStudents');

	Route::get('search/all-students/ac/{cycle}/class/{class}', $studentapi . 'getSearchAllListStudents');

	Route::get('get/allotted-students/ac/{cycle}/class/{class}', $studentapi . 'getAllAllottedStudents');

	Route::get('search/allotted-students/ac/{cycle}/class/{class}', $studentapi . 'getSearchAllAllottedStudents');

	Route::get('get/enrolled-students/ac/{cycle}/class/{class}', $studentapi . 'getAllEnrolledStudents');

	Route::get('search/enrolled-students/ac/{cycle}/class/{class}', $studentapi . 'getSearchAllEnrolledStudents');

	Route::get('get/rejected-students/ac/{cycle}/class/{class}', $studentapi . 'getAllRejectedStudents');

	Route::get('get/dropout-students/ac/{cycle}/class/{class}', $studentapi . 'getAllDropoutStudents');

	Route::get('search/rejected-students/ac/{cycle}/class/{class}', $studentapi . 'getSearchAllRejectedStudents');

	Route::get('search/dropout-students/ac/{cycle}/class/{class}', $studentapi . 'getSearchAllDropoutStudents');

	
	Route::post('allstudents/cycle/{cycle}/class/{class}/download', $studentapi . 'postDownloadAllStudents');

	Route::post('allotted-students/cycle/{cycle}/class/{class}/download', $studentapi . 'postDownloadAllottedStudents');

	Route::post('enrolled-students/cycle/{cycle}/class/{class}/download', $studentapi . 'postDownloadEnrolledStudents');

	Route::post('rejected-students/cycle/{cycle}/class/{class}/download', $studentapi . 'postDownloadRejectedStudents');

	Route::post('dropout-students/cycle/{cycle}/class/{class}/download', $studentapi . 'postDownloadDropoutStudents');
});

Route::group(['middleware' => ['role:role-school-admin', 'web'], 'namespace' => 'Student', 'prefix' => 'schooladmin'], function () {

	$c = 'StudentViewController@';

	Route::get('student-details/{registration_id}', ['as' => 'schooladmin.student.details', 'uses' => $c . 'getStudentDetailsView']);

	Route::get('students', ['as' => 'schooladmin.students', 'uses' => $c . 'getAllStudentsView']);

	Route::get('allotted-students', ['as' => 'schooladmin.allotted-students', 'uses' => $c . 'getAllottedStudentsView']);

	Route::get('enrolled-students', ['as' => 'schooladmin.enrolled-students', 'uses' => $c . 'getEnrolledStudentsView']);

	Route::get('rejected-students', ['as' => 'schooladmin.rejected-students', 'uses' => $c . 'getRejectedStudentsView']);

	Route::get('dropout-students', ['as' => 'schooladmin.dropout-students', 'uses' => $c . 'getDroppedStudentsView']);

	Route::get('add-subject', ['as' => 'schooladmin.add-subject', 'uses' => $c . 'getAddSubjectView']);

	Route::get('attendance', ['as' => 'schooladmin.attendance', 'uses' => $c . 'getAttendanceView']);

	Route::get('grade', ['as' => 'schooladmin.grade', 'uses' => $c . 'getGradeView']);

	Route::get('{student_id}/add-attendance', ['as' => 'schooladmin.add-attendance', 'uses' => $c . 'getAddAttendanceView'])->where('student_id', '[0-9]+');

	Route::get('{student_id}/add-grade', ['as' => 'schooladmin.add-grade', 'uses' => $c . 'getAddGradeView'])->where('student_id', '[0-9]+');

});