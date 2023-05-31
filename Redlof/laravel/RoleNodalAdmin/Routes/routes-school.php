<?php

Route::group(['middleware' => ['role:role-nodal-admin', 'web'], 'prefix' => 'nodaladmin', 'namespace' => 'School'], function () {

    $schoolview = 'SchoolViewController@';

    Route::get('all-schools', ['as' => 'school.all-schools', 'uses' => $schoolview . 'getAllSchoolsView'])
        ->where('state', '[a-z\-]+');

    Route::get('registered-schools', ['as' => 'school.registered-schools', 'uses' => $schoolview . 'getSchoolView'])
        ->where('state', '[a-z\-]+');

    Route::get('verified-schools', ['as' => 'school.verified-schools', 'uses' => $schoolview . 'getRegisteredSchoolView'])
        ->where('state', '[a-z\-]+');

    Route::get('banned-schools', ['as' => 'school.banned-schools', 'uses' => $schoolview . 'getBannedSchoolView'])
        ->where('state', '[a-z\-]+');

    Route::get('rejected-schools', ['as' => 'school.rejected-schools', 'uses' => $schoolview . 'getRejectedSchoolView'])
        ->where('state', '[a-z\-]+');

    Route::get('add-school', ['as' => 'school.add-school', 'uses' => $schoolview . 'getAddSchoolView']);

    Route::get('add-school/{udise}/add-address', ['as' => 'school.add-school-address', 'uses' => $schoolview . 'getAddSchoolAddressView'])->where('udise', '[0-9]+');

    Route::get('add-school/{udise}/add-region', ['as' => 'school.add-school-region', 'uses' => $schoolview . 'getAddSchoolRegionView'])->where('udise', '[0-9]+');

    Route::get('school/{school_id}', ['as' => 'school.school-details', 'uses' => $schoolview . 'schoolDetailsView'])->where('school_id', '[0-9]+');

    Route::get('school/{school_id}/edit-school', ['as' => 'school.school-edit', 'uses' => $schoolview . 'editSchoolPrimaryView'])->where('school_id', '[0-9]+');

    Route::get('school/{udise}/edit-address', ['as' => 'nodaladmin.edit-school-address', 'uses' => $schoolview . 'editSchoolAddressView'])->where('udise', '[0-9]+');

    Route::get('school/{udise}/update-region', ['as' => 'nodaladmin.update-region', 'uses' => $schoolview . 'editSchoolRegionView'])->where('udise', '[0-9]+');

    Route::get('school/{udise}/update-fee', ['as' => 'nodaladmin.update-fee', 'uses' => $schoolview . 'editSchoolFeeView'])->where('udise', '[0-9]+');

    Route::get('school/{udise}/update-bank', ['as' => 'nodaladmin.update-bank', 'uses' => $schoolview . 'editSchoolBankView'])->where('udise', '[0-9]+');

    Route::get('school/delete/repeated', ['as' => 'nodaladmin.delete-school', 'uses' => $schoolview . 'getDeleteSchoolView'])->where('udise', '[0-9]+');

});

Route::group(array('prefix' => 'api/nodaladmin', 'namespace' => 'School'), function () {

    $schoolapi = 'SchoolController@';

    Route::get('get/allschool/list', $schoolapi . 'getAllSchool');
    Route::get('get/school/all/list', $schoolapi . 'getSchoolsAllList');

    Route::get('get/schools/all', $schoolapi . 'getSchoolsAll');

    Route::get('get/rejected-schools', $schoolapi . 'getRejectedSchools');

    Route::get('school/details/{school_id}', $schoolapi . 'getSchoolDetails');

    Route::get('get/registered-schools', $schoolapi . 'getRegisteredSchools');

    Route::get('get/verified-schools', $schoolapi . 'getVerifiedSchools');

    Route::get('get/banned-schools', $schoolapi . 'getBannedSchools');

    Route::get('schools/search', $schoolapi . 'getSearchSchools');

    Route::get('schools/search/list', $schoolapi . 'getSearchSchoolslist');

    Route::get('schools/search-registered', $schoolapi . 'getSearchRegisteredSchools');

    Route::get('schools/search-rejected', $schoolapi . 'getSearchRejectedSchools');

    Route::get('schools/search-banned', $schoolapi . 'getSearchBannedSchools');

    Route::get('delete/schools', $schoolapi . 'deleteSchoolsRepeated');

    Route::get('get/school-details/{school_id}', $schoolapi . 'getSchoolEditDetails')->where('school_id', '[0-9]+');

    Route::get('get/school-address-details/{school_id}', $schoolapi . 'getSchoolAddressDetails')->where('school_id', '[0-9]+');

    Route::get('get/school-region-details/{school_id}', $schoolapi . 'getSchoolRegionDetails')->where('school_id', '[0-9]+');

    Route::get('get/school-fee-details/{school_id}', $schoolapi . 'getSchoolFeeDetails')->where('school_id', '[0-9]+');

    Route::get('get/school-seat-details/{udise}', $schoolapi . 'getSchoolSeatDetails')->where('udise', '[0-9]+');

    Route::get('get/past-seat-details/{udise}', $schoolapi . 'getPastSeatDetails')->where('udise', '[0-9]+');

    Route::get('get/school-bank-details/{school_id}', $schoolapi . 'getSchoolBankDetails')->where('school_id', '[0-9]+');

    Route::post('get/schools/all/download', $schoolapi . 'getDownloadSchoolsAll');

    Route::post('get/schools/all/download/list', $schoolapi . 'getDownloadSchoolsAllList');

    Route::post('get/registered-schools/download', $schoolapi . 'getDownloadRegisteredSchools');

    Route::post('get/rejected-schools/download', $schoolapi . 'getDownloadRejectedSchools');

    Route::post('get/banned-schools/download', $schoolapi . 'getDownloadBannedSchools');

    Route::post('add/school', $schoolapi . 'postSchoolAdd');

    Route::post('{state}/new/school/add-address/{udise}', 'SchoolController@addSchoolAddress')->where('state', '[a-z\-]+')->where('udise', '[0-9]+');

    Route::post('school/update/details', $schoolapi . 'postSchoolUpdateDetails');

    Route::post('school/accept/{school_id}', $schoolapi . 'postAcceptSchool')->where('school_id', '[0-9]+');

    Route::post('school/reject/{school_id}', $schoolapi . 'postRejectSchool')->where('school_id', '[0-9]+');

    Route::post('school/recheck/{school_id}', $schoolapi . 'postRecheckSchool')->where('school_id', '[0-9]+');

    Route::post('school/ban/{school_id}', $schoolapi . 'postBanSchool')->where('school_id', '[0-9]+');

    Route::post('school/unverify/{school_id}', $schoolapi . 'postUnVerifySchool')->where('school_id', '[0-9]+');

    Route::post('school/unban/{school_id}', $schoolapi . 'postUnBanSchool')->where('school_id', '[0-9]+');

    Route::post('school/update', $schoolapi . 'postSchoolUpdate');

    Route::post('school/nodaladmin/add', $schoolapi . 'postAddSchoolNodalAdmin');

    Route::post('school/update/{school_id}', $schoolapi . 'postUpdatePrimaryDetials');

    Route::post('school/update/address/{school_id}', $schoolapi . 'postUpdateAddressDetials');

    Route::post('school/update/region/{udise}', $schoolapi . 'postUpdateRegionDetials');

    Route::post('school/update/seat/{udise}', $schoolapi . 'postUpdateSeatDetials');

    Route::post('school/update/bank/{udise}', $schoolapi . 'postUpdateBankDetials');

    Route::get('school/allottment-details/{school_id}', $schoolapi . 'getSchoolAllottmentDetails')->where('school_id', '[0-9]+');

});
