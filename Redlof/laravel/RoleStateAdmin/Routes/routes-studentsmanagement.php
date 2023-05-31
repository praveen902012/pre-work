<?php

Route::group(['middleware' => ['role:role-state-admin', 'web'], 'namespace' => 'StudentsManagement'], function () {

    Route::get('stateadmin/registeredstudents', ['as' => 'stateadmin.registeredstudents', 'uses' => 'RoleStateAdminStudentViewController@getRegisteredStudentsView']);

    Route::get('stateadmin/students/{registration_no}', ['as' => 'stateadmin.students.single', 'uses' => 'RoleStateAdminStudentViewController@getSingleStudentsView']);

    Route::get('stateadmin/allottedstudents', ['as' => 'stateadmin.allotedstudents', 'uses' => 'RoleStateAdminStudentViewController@getAllotedStudentsView']);

    Route::get('stateadmin/enrolledstudents', ['as' => 'stateadmin.enrolledstudents', 'uses' => 'RoleStateAdminStudentViewController@getEnrolledStudentsView']);

    Route::get('stateadmin/dismissedstudents', ['as' => 'stateadmin.dismissedstudents', 'uses' => 'RoleStateAdminStudentViewController@getDismissedStudentsView']);

    Route::get('stateadmin/students/without/school', ['as' => 'stateadmin.student.without.school', 'uses' => 'RoleStateAdminStudentViewController@getStudentsWithoutSchool']);

});

Route::group(array('prefix' => 'api/stateadmin', 'namespace' => 'StudentsManagement'), function () {

    Route::get('registeredstudents', 'RoleStateAdminStudentController@getRegisteredStudents');

    Route::get('allottedstudents', 'RoleStateAdminStudentController@getAllottedStudents');

    Route::get('enrolledstudents', 'RoleStateAdminStudentController@getEnrolledStudents');

    Route::get('dismissedstudents', 'RoleStateAdminStudentController@getDissmissedStudents');

    Route::get('dismissedstudents/search', 'RoleStateAdminStudentController@searchDismissedStudents');

    Route::post('download/registeredstudents', 'RoleStateAdminStudentController@getDownoadRegisteredStudents');

    Route::post('download/allottedstudents', 'RoleStateAdminStudentController@getDownoadAllottedStudents');

    Route::post('download/enrolledstudents', 'RoleStateAdminStudentController@getDownoadEnrolledStudents');

    Route::post('download/dismissedstudents', 'RoleStateAdminStudentController@getDownoadDismissedStudents');

    Route::get('registeredstudents/search', 'RoleStateAdminStudentController@searchRegisteredStudents');

    Route::get('registeration/completed/students/search', 'RoleStateAdminStudentController@searchRegisterationCompletedStudents');

    Route::post('registeration/completed/students/{reg_no}/activate', 'RoleStateAdminStudentController@registerationCompletedStudentsActivate');

    Route::get('allottedstudents/search', 'RoleStateAdminStudentController@searchAllottedStudents');

    Route::get('enrolledstudents/search', 'RoleStateAdminStudentController@searchEnrolledStudents');

    Route::post('download/students/without/school', 'RoleStateAdminStudentController@getDownloadStudentWithoutSchool');

    Route::post('dismissedstudents/{registration_cycle_id}/re-allot', 'RoleStateAdminStudentController@postDismissedStudentsMarkAsAllotted');

});
