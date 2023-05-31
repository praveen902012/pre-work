<?php

Route::group(['middleware' => ['role:role-district-admin', 'web'], 'namespace' => 'School'], function () {

    Route::get('districtadmin/schools/all', ['as' => 'schools.all', 'uses' => 'SchoolViewController@getSchoolAllView']);

    Route::get('districtadmin/schools/registered', ['as' => 'schools.registered', 'uses' => 'SchoolViewController@getSchoolRegisteredView']);

    Route::get('districtadmin/schools/verified', ['as' => 'schools.verified', 'uses' => 'SchoolViewController@getSchoolVerifiedView']);

    Route::get('districtadmin/schools/assigned', ['as' => 'schools.assigned', 'uses' => 'SchoolViewController@getSchoolAssignedView']);

    Route::get('districtadmin/schools/rejected', ['as' => 'schools.rejected', 'uses' => 'SchoolViewController@getSchoolRejectedView']);

    Route::get('districtadmin/schools/banned', ['as' => 'schools.banned', 'uses' => 'SchoolViewController@getSchoolBannedView']);

    Route::get('districtadmin/school/{school_id}', ['as' => 'schools.details', 'uses' => 'SchoolViewController@schoolDetailsView'])->where('school_id', '[0-9]+');

    Route::get('districtadmin/school-reimbursement', ['as' => 'schools.reimbursement.school', 'uses' => 'SchoolViewController@getSchoolReimbursementView']);

    Route::get('districtadmin/student-reimbursement', ['as' => 'schools.reimbursement.student', 'uses' => 'SchoolViewController@getStudentReimbursementView']);

    Route::get('districtadmin/school-student-reimbursement/{school_id}', ['as' => 'schools.reimbursement.school-student', 'uses' => 'SchoolViewController@getSchoolStudentReimbursementView']);

});

Route::group(array('prefix' => 'api/districtadmin', 'namespace' => 'School', 'middleware' => ['throttle:60,60']), function () {

    Route::get('get/schools/ac/{cycle}/sop/{status}/nodal/{nodal_id}', 'SchoolController@getAllSchools');

    Route::get('search/schools/ac/{cycle}/sop/{status}/nodal/{nodal_id}', 'SchoolController@getSearchAllSchools');

    Route::get('get/students/ac/{cycle}/sop/{status}/nodal/{nodal_id}/school/{school_id}', 'SchoolController@getAllStudents');

    Route::get('search/students/ac/{cycle}/sop/{status}/nodal/{nodal_id}/school/{school_id}', 'SchoolController@getSearchAllStudents');

    Route::get('get/schools/all/{district_id}/payment/{type}', 'SchoolController@getSchoolsPaymentType')->where('district_id', '[0-9]+');

    Route::get('get/schools/all/{district_id}', 'SchoolController@getAllListSchools')->where('district_id', '[0-9]+');

    Route::get('get/schools/registered/{district_id}', 'SchoolController@getAllRegisteredSchools')->where('district_id', '[0-9]+');

    Route::get('get/schools/assigned/{district_id}', 'SchoolController@getAllAssignedSchools')->where('district_id', '[0-9]+');

    Route::post('get/schools/all/{district_id}/download', 'SchoolController@getDownloadAllSchools')->where('district_id', '[0-9]+');

    Route::post('get/schools/registered/{district_id}/download', 'SchoolController@getDownloadAllRegisteredSchools')->where('district_id', '[0-9]+');

    Route::get('search/schools/all/{district_id}', 'SchoolController@getSearchAllSchoolsList')->where('district_id', '[0-9]+');

    Route::get('search/schools/registered/{district_id}', 'SchoolController@getSearchRegisteredSchools')->where('district_id', '[0-9]+');

    Route::get('search/schools/assigned/{district_id}', 'SchoolController@getSearchAssignedSchools')->where('district_id', '[0-9]+');

    Route::get('get/schools/verified/{district_id}', 'SchoolController@getAllVerifiedSchools')->where('district_id', '[0-9]+');

    Route::post('get/schools/verified/{district_id}/download', 'SchoolController@getDownloadAllVerifiedSchools')->where('district_id', '[0-9]+');

    Route::get('search/schools/verified/{district_id}', 'SchoolController@getSearchVerifiedSchools')->where('district_id', '[0-9]+');

    Route::get('get/schools/rejected/{district_id}', 'SchoolController@getAllRejectedSchools')->where('district_id', '[0-9]+');

    Route::post('get/schools/rejected/{district_id}/download', 'SchoolController@getDownloadAllRejectedSchools')->where('district_id', '[0-9]+');

    Route::get('search/schools/rejected/{district_id}', 'SchoolController@getSearchRejectedSchools')->where('district_id', '[0-9]+');

    Route::get('get/schools/banned/{district_id}', 'SchoolController@getAllBannedSchools')->where('district_id', '[0-9]+');

    Route::post('get/schools/banned/{district_id}/download', 'SchoolController@getDownloadAllBannedSchools')->where('district_id', '[0-9]+');

    Route::get('search/schools/banned/{district_id}', 'SchoolController@getSearchBannedSchools')->where('district_id', '[0-9]+');

    Route::post('school/add', 'SchoolController@postSchoolAdd');

    Route::post('school/assign', 'SchoolController@postSchoolAssign');

    Route::post('school/re-assign', 'SchoolController@postSchoolReAssign');

    Route::post('school/delete/{school_id}', 'SchoolController@postSchoolDelete')->where('school_id', '[0-9]+');

    Route::get('school/unmapped/nodal/get', 'SchoolController@getUnmappedNodalSchools')->where('school_id', '[0-9]+');

    Route::post('school/report/download/ac/{cycle}/sop/{status}/nodal/{nodal_id}', ['uses' => 'SchoolController@postSchoolReportDownload']);

    Route::post('student/report/download/ac/{cycle}/sop/{status}/nodal/{nodal_id}/school/{school_id}', ['uses' => 'SchoolController@postStudentReportDownload']);

    Route::get('get/applicationcycle', 'SchoolController@getApplicationCycles');

    Route::get('get/schools/list', 'SchoolController@getSchoolList');

    Route::post('school/reimbursement/pay/{school_id}/amount/{amount}', 'SchoolController@postSchoolPayReimbursement')->where('school_id', '[0-9]+');

    Route::post('student/reimbursement/pay/{report_id}', 'SchoolController@postStudentPayReimbursement')->where('student_id', '[0-9]+');

    Route::post('school/reimbursement/payall', 'SchoolController@postSchoolPayAllReimbursement')->where('student_id', '[0-9]+');

    Route::get('get/school/nodal/{school_id}', 'SchoolController@getSchoolNodalAdmin');

    Route::post('pay/selected', 'SchoolController@postPaySelected');

    Route::post('pay/selected/students', 'SchoolController@postPaySelectedStudents');

    Route::get('get/school-allottment-details/{school_id}', 'SchoolController@getSchoolAllottmentDetails')->where('school_id', '[0-9]+');

});
