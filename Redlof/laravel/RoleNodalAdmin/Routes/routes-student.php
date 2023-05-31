<?php

Route::group(['middleware' => ['role:role-nodal-admin', 'web'], 'namespace' => 'Student'], function () {

    Route::get('nodaladmin/registeredstudents', ['as' => 'nodaladmin.registeredstudents', 'uses' => 'StudentViewController@getRegisteredStudentsView']);

    Route::get('nodaladmin/allstudents', ['as' => 'nodaladmin.allstudents', 'uses' => 'StudentViewController@getAllStudentsView']);

    Route::get('nodaladmin/allottedstudents', ['as' => 'nodaladmin.allotedstudents', 'uses' => 'StudentViewController@getAllotedStudentsView']);

    Route::get('nodaladmin/enrolledstudents', ['as' => 'nodaladmin.enrolledstudents', 'uses' => 'StudentViewController@getEnrolledStudentsView']);

    Route::get('nodaladmin/rejectedstudents', ['as' => 'nodaladmin.rejectedstudents', 'uses' => 'StudentViewController@getRejectedStudentsView']);

    Route::get('nodaladmin/verifiedstudents', ['as' => 'nodaladmin.verifiedstudents', 'uses' => 'StudentViewController@getVerifiedStudentsView']);

    Route::get('nodaladmin/allrejectedstudents', ['as' => 'nodaladmin.all.rejectedstudents', 'uses' => 'StudentViewController@getAllRejectedStudentsView']);

    Route::get('nodaladmin/dropout-pending', ['as' => 'nodaladmin.dropout.pending', 'uses' => 'StudentViewController@getDropoutPendingView']);

    Route::get('nodaladmin/dropoutstudents', ['as' => 'nodaladmin.dropout.students', 'uses' => 'StudentViewController@getDropoutStudentsView']);

    Route::get('nodaladmin/student-details/{registration_id}', ['as' => 'nodaladmin.student.details', 'uses' => 'StudentViewController@getStudentDetailsView']);

});

Route::group(array('prefix' => 'api/nodaladmin', 'namespace' => 'Student', 'middleware' => ['throttle:60,60']), function () {

    Route::get('registeredstudents', 'StudentController@getRegisteredStudents');

    Route::get('allstudents', 'StudentController@getAllStudents');

    Route::get('allstudents/searchByName','StudentController@getSearchByNameAllStudents');

    Route::get('enrolledstudents/searchByName','StudentController@getSearchByNameEnrolledStudents');

    Route::get('allrejected-students/search','StudentController@getSearchByNameAllRejectedStudents');

    Route::get('student/search-registered','StudentController@getSearchRejectedStudents');

    Route::post('allstudents/download', 'StudentController@getDownloadAllStudents');

    Route::get('allottedstudents', 'StudentController@getAllottedStudents');

    Route::get('allotedschools/searchByName', 'StudentController@getSearchAllottedStudents');

    Route::get('students/all', 'StudentController@getStudentsAll');

    Route::post('allottedstudents/download', 'StudentController@getDownloadAllottedStudents');

    Route::get('enrolledstudents', 'StudentController@getEnrolledStudents');

    Route::post('enrolledstudents/download', 'StudentController@getDownloadEnrolledStudents');

    Route::get('rejected-students', 'StudentController@getRejectedStudents');

    Route::post('rejectedstudents/download', 'StudentController@getDownloadRejectedStudents');

    Route::get('allrejected-students', 'StudentController@getAllRejectedStudents');

    Route::post('allrejectedstudents/download', 'StudentController@getDownloadAllRejectedStudents');

    Route::get('dropout/pending', 'StudentController@getDropoutPending');

    Route::get('dropout/verified', 'StudentController@getDropoutVerified');

    Route::get('search/registeredstudents', 'StudentController@getSearchRegisteredStudents');

    Route::post('student/mark-dropout/{student_id}', 'StudentController@postMarkStudentDropout');

    Route::post('student/mark-reject/{student_id}', 'StudentController@postMarkStudentReject');

    Route::post('student/reject-reject/{student_id}', 'StudentController@postCancelStudentReject');

});