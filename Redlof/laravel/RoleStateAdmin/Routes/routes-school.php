<?php

Route::group(['middleware' => ['role:role-state-admin', 'web'], 'namespace' => 'School', 'prefix' => 'stateadmin'], function () {

    $schoolview = 'SchoolViewController@';

    Route::get('schools', ['as' => 'stateadmin.school.getall', 'uses' => $schoolview . 'getSchoolView']);

    Route::get('schools-edit', ['as' => 'stateadmin.school.edit', 'uses' => $schoolview . 'getSchoolEditView']);

    Route::get('student-edit', ['as' => 'stateadmin.student.edit', 'uses' => $schoolview . 'getStudentEditView']);

    Route::get('schools/{school_id}', ['as' => 'stateadmin.single-school.get', 'uses' => $schoolview . 'getSingleSchoolView']);

    Route::get('add/subjects', ['as' => 'stateadmin.subject.add', 'uses' => $schoolview . 'getSubjectsView']);

    Route::get('applied-students/{udise}', ['as' => 'stateadmin.applied.student', 'uses' => $schoolview . 'getAllAppliedStudentOfCollege']);
});

Route::group(array('prefix' => 'api/stateadmin', 'namespace' => 'School', 'middleware' => ['throttle:60,60']), function () {

    $schoolapi = 'SchoolController@';

    Route::get('get/registered-schools', $schoolapi . 'getRegisteredSchools');

    Route::get('get/verified-schools', $schoolapi . 'getVerifiedSchools');

    Route::post('get/schools/download', $schoolapi . 'getDownloadSchools');

    Route::post('download/applied-student/{udise}', $schoolapi . 'postDownloadAppliedStudents');

    Route::post('student-phone/update', $schoolapi . 'postStudentPhoneUpdate');

    Route::get('schools/search-registered', $schoolapi . 'getSearchRegisteredSchools');

    Route::get('schools/search-verified', $schoolapi . 'getSearchVerifiedSchools');

    Route::get('get/school-admin/{school_id}', $schoolapi . 'getSchoolAdminDetail');

    Route::post('school-admin/update', $schoolapi . 'postSchoolAdminUpdate');

    Route::post('school/{udise}/seat-info/update', $schoolapi . 'postSchoolSeatInfoUpdate');

    Route::post('school/add', $schoolapi . 'postSchoolAdd');

    Route::post('school/delete/{school_id}', $schoolapi . 'postSchoolDelete')->where('school_id', '[0-9]+');

    Route::get('get/school-fee-details/{school_id}', $schoolapi . 'getSchoolFeeDetails')->where('school_id', '[0-9]+');

    Route::get('get/school-allottment-details/{school_id}', $schoolapi . 'getSchoolAllottmentDetails')->where('school_id', '[0-9]+');

    Route::get('get/school-seat-details/{udise}', $schoolapi . 'getSchoolSeatDetails')->where('udise', '[0-9]+');

    Route::get('get/past-seat-details/{udise}', $schoolapi . 'getPastSeatDetails')->where('udise', '[0-9]+');

    Route::get('get/school-region-details/{school_id}', $schoolapi . 'getSchoolRegionDetails')->where('school_id', '[0-9]+');

    Route::post('school/update/region/{school_id}', $schoolapi . 'postUpdateRegionDetials');

    Route::post('school/recheck/{school_id}', $schoolapi . 'postRecheckSchool')->where('school_id', '[0-9]+');

});
