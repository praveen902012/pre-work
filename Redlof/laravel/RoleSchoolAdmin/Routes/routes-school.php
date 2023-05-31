<?php

Route::group(array('prefix' => 'api/schooladmin', 'namespace' => 'School'), function () {
	Route::post('{state}/new/school/add', 'SchoolController@addSchool')->where('state', '[a-z\-]+');

	Route::get('{state}/get/languages/all', 'SchoolController@getLanguages')->where('state', '[a-z\-]+');

	Route::get('{state}/get/levels/all', 'SchoolController@getLevels')->where('state', '[a-z\-]+');

	Route::get('{state}/get/schools/all', 'SchoolController@getSchools')->where('state', '[a-z\-]+');

	Route::get('{state}/schools/search', 'SchoolController@getSearchSchools')->where('state', '[a-z\-]+');

	Route::get('get/fee-structure', 'SchoolController@getFeeStructure');

	Route::get('get/seat-info', 'SchoolController@getSeatInfo');

	Route::get('get/students/reimbursement/all', 'SchoolController@getStudentsForReimbursement');

	Route::post('get/students/reimbursement/all/download', 'SchoolController@getStudentsForReimbursementDownload');

	Route::get('get/school-details/{school_id}', 'SchoolController@getSchoolDetails');

	Route::get('get/school-address-details/{school_id}', 'SchoolController@getSchoolAddressDetails');

	Route::get('get/school-region-details/{school_id}', 'SchoolController@getSchoolRegionDetails');


	Route::get('get/school-fee-details/{school_id}', 'SchoolController@getSchoolFeeDetails');

	Route::get('get/school-seat-details/{udise}', 'SchoolController@getSchoolSeatDetails');

	Route::get('get/past-seat-details/{udise}', 'SchoolController@getPastSeatDetails');

	
	Route::get('get/school-bank-details/{school_id}', 'SchoolController@getSchoolBankDetails');

	Route::post('school/update/{school_id}', 'SchoolController@updateSchool');

	Route::post('school/update/address/{school_id}', 'SchoolController@updateSchoolAddress');

	Route::post('school/update/region/{school_id}', 'SchoolController@updateSchoolRegion');

	Route::post('school/update/seat/{udise}', 'SchoolController@updateSchoolSeat');

	Route::post('school/update/bank/{udise}', 'SchoolController@updateSchoolBank');

	Route::post('school/level-fee/add', 'SchoolController@addSchoolLevelFeeInfo')->where('state', '[a-z\-]+');
	Route::post('school/level-seat/add', 'SchoolController@addSchoolLevelSeatInfo')->where('state', '[a-z\-]+');

	Route::post('school/reimbursement/not_received', 'SchoolController@updateReimbursement');

	Route::post('school/reimbursement/received', 'SchoolController@updateReimbursementReceived');

	Route::get('school/reset/all', 'SchoolController@getResetAll');

	Route::post('school/verify/phone', 'SchoolController@verifySchoolPhone');

	Route::post('school/verify/phone/otp', 'SchoolController@verifySchoolOTP');

});

Route::group(['middleware' => ['role:role-school-admin', 'web'], 'namespace' => 'Role', 'prefix' => 'schooladmin'], function () {
	$c = 'RoleSchoolAdminViewController@';

	Route::get('school-registration', ['as' => 'schooladmin.school-reg', 'uses' => $c . 'getRegisterYourSchool']);

	Route::get('reimbursement', ['as' => 'schooladmin.reimbursement', 'uses' => $c . 'getReimbursementView']);

	Route::get('help/reset', ['as' => 'schooladmin.reset', 'uses' => $c . 'getResetView']);

});