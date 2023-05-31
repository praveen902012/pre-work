<?php

Route::group(['middleware' => ['web'], 'namespace' => 'Registration'], function () {

	Route::get('{state}/student-registration', ['as' => 'state.registration', 'uses' => 'RegistrationViewController@getRegistrationPage'])->where('state', '[a-z\-]+');

	Route::get('{state}/student-registration/{registration_id}/parent-details', ['as' => 'state.registration.parent', 'uses' => 'RegistrationViewController@getRegistrationParentPage'])->where('state', '[a-z\-]+')->where('registration_id', '[0-9]+');

	Route::get('{state}/student-registration/{registration_id}/address-details', ['as' => 'state.registration.address', 'uses' => 'RegistrationViewController@getRegistrationAddressPage'])->where('state', '[a-z\-]+')->where('registration_id', '[0-9]+');

	Route::get('{state}/student-registration/{registration_id}/verify-documents', ['as' => 'state.registration.documents', 'uses' => 'RegistrationViewController@getRegistrationFilesPage'])->where('state', '[a-z\-]+')->where('registration_id', '[0-9]+');

	Route::get('{state}/student-registration/{registration_id}/school-selection', ['as' => 'state.registration.schools', 'uses' => 'RegistrationViewController@getRegistrationSchoolsPage'])->where('state', '[a-z\-]+')->where('registration_id', '[0-9]+');

	Route::get('{state}/student-registration/{registration_id}/personal-details', ['as' => 'state.registration.update', 'uses' => 'RegistrationViewController@getRegistrationUpdatePage'])->where('state', '[a-z\-]+')->where('registration_id', '[0-9]+');

	Route::get('{state}/student-registration/{registration_id}/preview', ['as' => 'state.registration.preview', 'uses' => 'RegistrationViewController@getRegistrationPreviewPage'])->where('state', '[a-z\-]+')->where('registration_id', '[0-9]+');

	Route::get('{state}/student-registration/{registration_id}/success', ['as' => 'state.registration.success', 'uses' => 'RegistrationViewController@getRegistrationSuccessPage'])->where('state', '[a-z\-]+')->where('registration_id', '[0-9]+');

	Route::get('{state}/student-registration/{registration_id}/result', ['as' => 'state.registration.result', 'uses' => 'RegistrationViewController@getRegistrationResultPage'])->where('state', '[a-z\-]+')->where('registration_id', '[0-9]+');

	Route::get('{state}/student-registration/{registration_id}/registration-form', ['as' => 'state.registration.form', 'uses' => 'RegistrationViewController@getRegistrationForm'])->where('state', '[a-z\-]+')->where('registration_id', '[0-9]+');

	Route::get('{state}/student-registration/{registration_id}/close-session-form', ['as' => 'state.registration.logout', 'uses' => 'RegistrationViewController@getLogoutView'])->where('state', '[a-z\-]+')->where('registration_id', '[0-9]+');

});

Route::group(array('prefix' => 'api', 'namespace' => 'Registration', 'middleware' => ['web']), function () {

	Route::get('{state}/levels/list', 'RegistrationController@getLevels')->where('state', '[a-z\-]+');

	Route::post('{state}/student-registration/step1/save', 'RegistrationController@postRegistratonStep1')->where('state', '[a-z\-]+');

	Route::post('{state}/student-registration/step1/update', 'RegistrationController@updateRegistratonStep1')->where('state', '[a-z\-]+');

	Route::get('{state}/student-registration/step1/get', 'RegistrationController@getRegistratonStep1')->where('state', '[a-z\-]+');

	Route::post('{state}/student-registration/step2/update', 'RegistrationController@postRegistratonStep2')->where('state', '[a-z\-]+');

	Route::get('{state}/student-registration/step2/get', 'RegistrationController@getRegistratonStep2')->where('state', '[a-z\-]+');

	Route::post('{state}/student-registration/step3/update', 'RegistrationController@postRegistratonStep3')->where('state', '[a-z\-]+');

	Route::get('{state}/student-registration/step3/get', 'RegistrationController@getRegistratonStep3')->where('state', '[a-z\-]+');

	Route::get('{state}/student-registration/step4/get', 'RegistrationController@getRegistratonStep4')->where('state', '[a-z\-]+');

	Route::post('{state}/student-registration/step4/update', 'RegistrationController@postRegistratonStep4')->where('state', '[a-z\-]+');

	Route::post('{state}/student-registration/step5/update', 'RegistrationController@postRegistratonStep5')->where('state', '[a-z\-]+');

	Route::post('{state}/student-registration/step5/save', 'RegistrationController@postRegistratonSaveStep5')->where('state', '[a-z\-]+');
	
	Route::post('{state}/student-registration/apply', 'RegistrationController@postSaveData')->where('state', '[a-z\-]+');

	Route::get('{state}/student-registration/report/admission-deny/{registration_id}', 'RegistrationController@reportAdmission')->where('state', '[a-z\-]+');

	Route::get('{state}/student-registration/report/check/{registration_id}', 'RegistrationController@checkReportAdmission')->where('state', '[a-z\-]+');

	//Mobile API

	Route::get('{state}/student-registration/step1/get/{registration_no}/{token}', 'RegistrationController@getAPIRegistratonStep1')->where('state', '[a-z\-]+');

	Route::post('{state}/student-registration/step1/update/{registration_no}/{token}', 'RegistrationController@updateAPIRegistratonStep1')->where('state', '[a-z\-]+');

	Route::post('{state}/student-registration/step2/update/{registration_no}/{token}', 'RegistrationController@postAPIRegistratonStep2')->where('state', '[a-z\-]+');

	Route::get('{state}/student-registration/step2/get/{registration_no}/{token}', 'RegistrationController@getAPIRegistratonStep2')->where('state', '[a-z\-]+');

	Route::post('{state}/student-registration/step3/update/{registration_no}/{token}', 'RegistrationController@postAPIRegistratonStep3')->where('state', '[a-z\-]+');

	Route::get('{state}/student-registration/step3/get/{registration_no}/{token}', 'RegistrationController@getAPIRegistratonStep3')->where('state', '[a-z\-]+');

	Route::get('{state}/student-registration/step4/get/{registration_no}/{token}', 'RegistrationController@getAPIRegistratonStep4')->where('state', '[a-z\-]+');

	Route::post('{state}/student-registration/step4/update/{registration_no}/{token}', 'RegistrationController@postAPIRegistratonStep4')->where('state', '[a-z\-]+');

	Route::post('{state}/student-registration/step5/update/{registration_no}/{token}', 'RegistrationController@postAPIRegistratonStep5')->where('state', '[a-z\-]+');

	//Other API

	Route::get('{state}/states', 'RegistrationController@getStates')->where('state', '[a-z\-]+');

	Route::get('{state}/search/district/{state_id}/{keyword}', 'RegistrationController@getDistricts')->where('state', '[a-z\-]+')->where('state_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

	Route::get('{state}/getall/district/{state_id}', 'RegistrationController@getAllStateDistricts')->where('state', '[a-z\-]+')->where('state_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

	Route::get('{state}/search/block/{district_id}/{keyword}', 'RegistrationController@searchBlock')->where('state', '[a-z\-]+')->where('district_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');
	
	Route::get('{state}/get/clusters/{block_id}', 'RegistrationController@getClusters')->where('state', '[a-z\-]+')->where('district_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

	Route::get('{state}/getall/block/{district_id}', 'RegistrationController@getAllDistrictBlock')->where('state', '[a-z\-]+')->where('district_id', '[0-9]+');

	Route::get('{state}/getall/subblock/{district_id}/{stype}/{block_id}', 'RegistrationController@getAllDistrictSubBlock')->where('state', '[a-z\-]+')->where('block_id', '[0-9]+')->where('stype', '[a-z\-]+')->where('district_id','[0-9]+');

	Route::get('{state}/search/locality/{block_id}/{keyword}', 'RegistrationController@searchLocality')->where('state', '[a-z\-]+')->where('block_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

	Route::get('{state}/search/locality/{block_id}', 'RegistrationController@getAllLocality')->where('state', '[a-z\-]+')->where('block_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

	Route::get('{state}/search/sublocality/{locality_id}/{keyword}', 'RegistrationController@searchSubLocality')->where('state', '[a-z\-]+')->where('locality_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

	Route::get('{state}/search/subsublocality/{sub_locality_id}/{keyword}', 'RegistrationController@searchSubSubLocality')->where('state', '[a-z\-]+')->where('sub_locality_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

	Route::get('{state}/student-registration/schools/get', 'RegistrationController@getNearBySchools')->where('state', '[a-z\-]+');

	Route::get('{state}/student-registration/schools/get/step5/{registration_id}', 'RegistrationController@getStep5Data')->where('state', '[a-z\-]+');

	Route::post('{state}/student/registration/result', 'RegistrationController@getStudentResult')->where('state', '[a-z\-]+');

	Route::post('{state}/resume/registration', 'RegistrationController@resumeRegistration');

	Route::post('{state}/resend/otp', ['uses' => 'RegistrationController@postResendStudentOTP']);

	Route::post('{state}/verify/otp', ['uses' => 'RegistrationController@postVerifiyStudentOTP']);

	Route::get('{state}/download/registration-form/{registration_no}', 'RegistrationController@downloadApplication');

	Route::get('{state}/download/empty/registration-form', 'RegistrationController@downloadEmptyApplication');

	Route::post('{state}/report-school', ['uses' => 'RegistrationController@postReportSchool']);

	Route::get('{state}/check/registration/status', 'RegistrationController@getRegistrationStatus')->where('state', '[a-z\-]+');

	Route::get('{state}/check/lottery/status', 'RegistrationController@getLotteryStatus')->where('state', '[a-z\-]+');

	Route::get('{state}/check/district/status/{district_id}', 'RegistrationController@getDistrictRegistrationStatus')->where('state', '[a-z\-]+');

});