<?php

Route::group(['middleware' => ['web']], function () {

	Route::get('{state}/general-information/schools/status', ['as' => 'state.school.general.information.status', 'uses' => 'StateViewController@getSchoolStatusGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/school-results', ['as' => 'state.school.results', 'uses' => 'StateViewController@getSchoolResults'])->where('state', '[a-z\-]+');

	Route::get('{state}/school-registration/{udise_code}/result', ['as' => 'state.school.result-status', 'uses' => 'StateViewController@SchoolResultView'])->where('state', '[a-z\-]+');

});

Route::group(array('prefix' => 'api', 'namespace' => 'School', 'middleware' => ['web']), function () {

	Route::get('{state}/get/languages/all', 'SchoolController@getLanguages')->where('state', '[a-z\-]+');

	Route::get('{state}/get/levels/all', 'SchoolController@getLevels')->where('state', '[a-z\-]+');

	Route::post('{state}/school/verify/phone', 'SchoolController@verifySchoolPhone')->where('state', '[a-z\-]+');

	Route::post('{state}/school/resend/otp', 'SchoolController@resendSchoolOtp')->where('state', '[a-z\-]+');

	Route::post('{state}/school/verify/phone/otp', 'SchoolController@verifySchoolOTP')->where('state', '[a-z\-]+');

	Route::post('{state}/new/school/add', 'SchoolController@addSchool')->where('state', '[a-z\-]+');

	Route::post('{state}/new/school/update', 'SchoolController@updateSchool')->where('state', '[a-z\-]+');

	Route::post('{state}/new/school/add-address/{udise}', 'SchoolController@addSchoolAddress')->where('state', '[a-z\-]+')->where('udise', '[0-9\-]+');

	Route::post('{state}/school/{udise}/save/neighbourhood', 'SchoolController@AddSchoolNeighbourhood')->where('state', '[a-z\-]+')->where('udise', '[0-9\-]+');

	Route::get('{state}/school/get-details/{school_id}/for/{registration_id}', 'SchoolController@getSchoolDetails')->where('state', '[a-z\-]+')->where('school_id', '[0-9\-]+')->where('registration_id', '[0-9\-]+');

	Route::get('{state}/get/schools/all/{application_year}', 'SchoolController@getSchools')->where('state', '[a-z\-]+');

	Route::get('{state}/get/schools/verified/{application_year}', 'SchoolController@getVerifiedSchools')->where('state', '[a-z\-]+');

	Route::get('{state}/get/schools/rejected/{application_year}', 'SchoolController@getRejectedSchools')->where('state', '[a-z\-]+');

	Route::get('{state}/get/schools/banned/{application_year}', 'SchoolController@getBannedSchools')->where('state', '[a-z\-]+');

	Route::get('{state}/schools/all/{application_year}/search', 'SchoolController@getSearchSchools')->where('state', '[a-z\-]+');

	Route::get('{state}/schools/verified/{application_year}/search', 'SchoolController@getSearchVerifiedSchools')->where('state', '[a-z\-]+');

	Route::get('{state}/schools/rejected/{application_year}/search', 'SchoolController@getSearchRejectedSchools')->where('state', '[a-z\-]+');

	Route::get('{state}/schools/banned/{application_year}/search', 'SchoolController@getSearchBannedSchools')->where('state', '[a-z\-]+');

	Route::get('{state}/get/school-details/{udise}', 'SchoolController@getSchoolResumeDetails')->where('state', '[a-z\-]+')->where('udise', '[0-9]+');

	Route::get('{state}/get/school/{udise}/application/download', 'SchoolController@downloadApplication')->where('state', '[a-z\-]+')->where('udise', '[0-9]+');

	Route::get('{state}/get/school-address', 'SchoolController@getSchoolAddressDetails')->where('state', '[a-z\-]+');

	Route::get('{state}/get/school-region-details/{udise}', 'SchoolController@getSchoolRegionDetails')->where('state', '[a-z\-]+')->where('udise', '[0-9]+');

	Route::get('{state}/get/school-bank-details/{udise}', 'SchoolController@getSchoolBankDetails')->where('state', '[a-z\-]+')->where('udise', '[0-9]+');

	Route::get('{state}/school/{school_id}/district/subsublocality/all', 'SchoolController@getDistrictSubSubLocalities')
		->where('state', '[a-z\-]+')
		->where('school_id', '[0-9]+');

	Route::get('{state}/school/{udise}/fee-structure', 'SchoolController@getSchoolFeeStructure')
		->where('state', '[a-z\-]+')
		->where('udise', '[0-9]+');

	Route::get('{state}/school/{udise}/sendsms', 'SchoolController@getSendSmsAgain')
		->where('state', '[a-z\-]+')
		->where('udise', '[0-9]+');

	Route::get('{state}/school/{udise}/get/seat-info', 'SchoolController@getSchoolSeatStructure')
		->where('state', '[a-z\-]+')
		->where('udise', '[0-9]+');

	Route::get('{state}/school/{udise}/get/past-seat-info', 'SchoolController@getPastSeatInfo')
		->where('state', '[a-z\-]+')
		->where('udise', '[0-9]+');

	Route::post('{state}/school/{udise}/save/seat-info', 'SchoolController@postSchoolFeeStructure')
		->where('state', '[a-z\-]+')
		->where('udise', '[0-9]+');

	Route::post('{state}/school/{udise}/bank-detail/save', 'SchoolController@postSchoolBankDetails')
		->where('state', '[a-z\-]+')
		->where('udise', '[0-9]+');

	Route::post('{state}/school/{udise}/save_data', 'SchoolController@postSaveData')
		->where('state', '[a-z\-]+')
		->where('udise', '[0-9]+');

	Route::post('{state}/resume/school/registration', 'SchoolController@postSchoolResume')
		->where('state', '[a-z\-]+');

	Route::post('{state}/resend/school/otp', 'SchoolController@postResendSchoolOTP')
		->where('state', '[a-z\-]+');

	Route::post('{state}/verify/school/otp', 'SchoolController@postVerifiySchoolOTP')
		->where('state', '[a-z\-]+');

	Route::post('{state}/download/wards/{district_id}', 'SchoolController@postDownloadWards')
		->where('state', '[a-z\-]+');

	Route::get('{state}/school/{udise}/get/school-status', 'SchoolController@getSchoolStatus')
		->where('state', '[a-z\-]+');

	//Following API is for verification, only for development purpose

	Route::get('{state}/school_list', 'SchoolController@getSchoolListDownload')
		->where('state', '[a-z\-]+');

	Route::get('{state}/not-selected-schools', 'SchoolController@getNotSelectedSchoolsDownload')
		->where('state', '[a-z\-]+');

	Route::get('{state}/get/schoolsData/all/', 'SchoolController@getSchoolsDataCount')->where('state', '[a-z\-]+');

	Route::post('{state}/school/registration/result', 'SchoolController@getSchoolRegistrationResult')
		->where('state', '[a-z\-]+');

});