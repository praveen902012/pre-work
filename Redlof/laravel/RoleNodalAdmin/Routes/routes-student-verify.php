<?php

Route::group(['middleware' => ['role:role-nodal-admin', 'web'], 'namespace' => 'Student'], function () {

	Route::get('nodaladmin/students/verify', ['as' => 'nodaladmin.students.verify', 'uses' => 'StudentViewController@getStudentsVerificationView']);
	Route::get('nodaladmin/students/verifed', ['as' => 'nodaladmin.students.verifed', 'uses' => 'StudentViewController@getStudentsDocVerified']);
	Route::get('nodaladmin/students/rejected', ['as' => 'nodaladmin.students.rejected', 'uses' => 'StudentViewController@getStudentsDocRejected']);

});

Route::group(array('prefix' => 'api/nodaladmin', 'namespace' => 'Student', 'middleware' => ['throttle:60,60']), function () {

	Route::get('studentsToVerify', 'StudentController@getAllAllottedStudents');
	Route::get('students/verify/{registration_id}','StudentController@verifyStudent');
	Route::post('students-verify/{registration_id}','StudentController@postverifyStudent');
	Route::post('students/undo/{registration_id}','StudentController@undoStudent');
	Route::post('students/rejectdoc','StudentController@rejectStudent');

	Route::get('verifiedstudentsdocs','StudentController@getVerifiedStudentsDocs');
	Route::get('rejectedstudentsdocs','StudentController@getRejectedStudentsDocs');

	Route::get('allotedschools/search','StudentController@getSearchAllottedStudents');
	Route::get('verifiedschools/search','StudentController@getSearchVerifiedStudents');
	Route::get('rejectedschools/search','StudentController@getSearchRejectedStudents');

	Route::get('verify-student/searchByName','StudentController@getSearchByNameVerifyStudents');
	Route::get('verified-student/searchByName','StudentController@getSearchByNameVerifiedStudents');
	Route::get('rejected-student/searchByName','StudentController@getSearchByNameRejectedStudents');

	Route::post('alldocstudents/download','StudentController@getDownloadAllAllottedStudents');
	Route::post('verifieddocstudents/download', 'StudentController@getDownloadVerifiedDocStudents');
	Route::post('rejecteddocstudents/download', 'StudentController@getDownloadRejectedDocStudents');
});