<?php

Route::group(['middleware' => ['role:role-district-admin', 'web'], 'namespace' => 'Student'], function () {

	Route::get('districtadmin/students', ['as' => 'districtadmin.students', 'uses' => 'DistrictAdminStudentViewController@getAllStudentsView']);

	Route::get('districtadmin/registeredstudents', ['as' => 'districtadmin.registeredstudents', 'uses' => 'DistrictAdminStudentViewController@getRegisteredStudentsView']);

	Route::get('districtadmin/allottedstudents', ['as' => 'districtadmin.allotedstudents', 'uses' => 'DistrictAdminStudentViewController@getAllotedStudentsView']);

	Route::get('districtadmin/enrolledstudents', ['as' => 'districtadmin.enrolledstudents', 'uses' => 'DistrictAdminStudentViewController@getEnrolledStudentsView']);

	Route::get('districtadmin/student/details/{registration_no}', ['as' => 'districtadmin.student.details', 'uses' => 'DistrictAdminStudentViewController@getStudentDetailsView']);

	Route::get('districtadmin/student/school-reports', ['as' => 'districtadmin.student.school-reports', 'uses' => 'DistrictAdminStudentViewController@getStudentReportsView']);

	Route::get('districtadmin/student/student-suspicious', ['as' => 'districtadmin.student.student-suspicious', 'uses' => 'DistrictAdminStudentViewController@getStudentSuspiciousView']);

	Route::get('districtadmin/student/admission-denied', ['as' => 'districtadmin.student.admission.denied', 'uses' => 'DistrictAdminStudentViewController@getAdmissionDeniedView']);

});

Route::group(array('prefix' => 'api/districtadmin', 'namespace' => 'Student', 'middleware' => ['throttle:60,60']), function () {

	Route::get('allstudents', 'DistrictAdminStudentController@getAllStudents');

	Route::get('search/allstudents', 'DistrictAdminStudentController@getSearchAllStudents');

	Route::post('allstudents/download', 'DistrictAdminStudentController@postDownloadAllStudents');


	Route::get('registeredstudents', 'DistrictAdminStudentController@getRegisteredStudents');

	Route::get('search/registeredstudents', 'DistrictAdminStudentController@getSearchRegisteredStudents');

	Route::post('registeredstudents/download', 'DistrictAdminStudentController@postDownloadRegisteredStudents');


	Route::get('allottedstudents', 'DistrictAdminStudentController@getAllottedStudents');

	Route::get('search/allottedstudents', 'DistrictAdminStudentController@getSearchAllottedStudents');

	Route::post('allottedstudents/download', 'DistrictAdminStudentController@postDownloadAllottedStudents');


	Route::get('enrolledstudents', 'DistrictAdminStudentController@getEnrolledStudents');

	Route::get('search/enrolledstudents', 'DistrictAdminStudentController@getSearchEnrolledStudents');

	Route::post('enrolledstudents/download', 'DistrictAdminStudentController@postDownloadEnrolledStudents');


	Route::get('school-reports', 'DistrictAdminStudentController@getSchoolReports');

	Route::get('denial-reports', 'DistrictAdminStudentController@getDenialReports');

	Route::get('suspicious-students', 'DistrictAdminStudentController@getSuspiciousStudents');

});