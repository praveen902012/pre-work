<?php

Route::group(['middleware' => ['web']], function () {

	Route::get('{state}', ['as' => 'state', 'uses' => 'StateViewController@getHome'])->where('state', '[a-z\-]+');

	Route::get('{state}/instructions', ['as' => 'state.instructions', 'uses' => 'StateViewController@getInstructions'])->where('state', '[a-z\-]+');

	Route::get('{state}/instructions/school-registration', ['as' => 'state.school-registration-instruction', 'uses' => 'StateViewController@getSchoolRegistrationInstructions'])->where('state', '[a-z\-]+');

	Route::get('{state}/instructions/student-registration', ['as' => 'state.student-registration-instruction', 'uses' => 'StateViewController@getStudentRegistrationInstructions'])->where('state', '[a-z\-]+');

	Route::get('{state}/instructions/government-registration', ['as' => 'state.government-registration-instruction', 'uses' => 'StateViewController@getgovernmentRegistrationInstructions'])->where('state', '[a-z\-]+');

	Route::get('{state}/registration/school-registration', ['as' => 'state.register-your-school', 'uses' => 'StateViewController@getRegisterYourSchool'])->where('state', '[a-z\-]+')->where('udise', '[0-9\-]+');

	Route::get('{state}/registration/school-registration/{udise}/address-details', ['as' => 'state.register-your-school.address-details', 'uses' => 'StateViewController@getSchoolAddress'])->where('state', '[a-z\-]+')->where('udise', '[0-9\-]+');

	Route::get('{state}/registration/school-registration/{udise}/primary-details', ['as' => 'state.register-your-school.resume-primary-details', 'uses' => 'StateViewController@getSchoolPrimary'])->where('state', '[a-z\-]+')->where('udise', '[0-9\-]+');

	Route::get('{state}/registration/school-registration/{udise}/region-selection', ['as' => 'state.register-your-school.region-selection', 'uses' => 'StateViewController@getSchoolRegion'])->where('state', '[a-z\-]+')->where('udise', '[0-9\-]+');

	Route::get('{state}/registration/school-registration/{udise}/class-info', ['as' => 'state.register-your-school.class-info', 'uses' => 'StateViewController@getSchoolClassView'])->where('state', '[a-z\-]+')->where('udise', '[0-9\-]+');

	Route::get('{state}/registration/school-registration/{udise}/bank-details', ['as' => 'state.register-your-school.bank-details', 'uses' => 'StateViewController@getSchoolBankDetailsView'])->where('state', '[a-z\-]+')->where('udise', '[0-9\-]+');

	Route::get('{state}/registration/school-registration/{udise}/preview', ['as' => 'state.school-registration-preview', 'uses' => 'StateViewController@getAllDetailsForPreview'])->where('state', '[a-z\-]+')->where('udise', '[0-9\-]+');

	Route::get('{state}/registration/{udise}/success', ['as' => 'state.school-registration', 'uses' => 'StateViewController@getSchoolRegistrationSuccess'])->where('state', '[a-z\-]+')->where('udise', '[0-9\-]+');

	Route::get('{state}/faq', ['as' => 'state.faq', 'uses' => 'StateViewController@getFaq'])->where('state', '[a-z\-]+');

	Route::get('{state}/student-results', ['as' => 'state.student.results', 'uses' => 'StateViewController@getResults'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information', ['as' => 'state.general.information', 'uses' => 'StateViewController@getInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/documents', ['as' => 'state.documents', 'uses' => 'StateViewController@getDocuments'])->where('state', '[a-z\-]+');

	Route::get('{state}/terms', ['as' => 'state.terms', 'uses' => 'StateViewController@getTerms'])->where('state', '[a-z\-]+');

	Route::get('{state}/privacy', ['as' => 'state.privacy', 'uses' => 'StateViewController@getPrivacy'])->where('state', '[a-z\-]+');

	Route::get('{state}/gallery', ['as' => 'state.gallery', 'uses' => 'StateViewController@getgallery'])->where('state', '[a-z\-]+');

	Route::get('{state}/reports', ['as' => 'state.reports', 'uses' => 'StateViewController@getReports'])->where('state', '[a-z\-]+');

	Route::get('{state}/faq/student-faq', ['as' => 'state.student-faq', 'uses' => 'StateViewController@getStudentFaq'])->where('state', '[a-z\-]+');

	Route::get('{state}/school/{school_id}/details/{registration_id}', ['as' => 'state.school-details', 'uses' => 'StateViewController@getSchoolDetails'])->where('state', '[a-z\-]+')->where('school_id', '[0-9\-]+')->where('registration_id', '[0-9\-]+');

	Route::get('{state}/faq/school-faq', ['as' => 'state.school-faq', 'uses' => 'StateViewController@getSchoolFaq'])->where('state', '[a-z\-]+');

	Route::get('{state}/state-signin', ['as' => 'state.state-admin.get', 'uses' => 'StateViewController@getStateAdminSignIn'])->where('state', '[a-z\-]+');

	Route::get('{state}/district-signin', ['as' => 'state.district-admin.get', 'uses' => 'StateViewController@getDistrictAdminSignIn'])->where('state', '[a-z\-]+');

	Route::get('{state}/nodal-signin', ['as' => 'state.nodal-admin.get', 'uses' => 'StateViewController@getNodalAdminSignIn'])->where('state', '[a-z\-]+');

	Route::get('{state}/school-signin', ['as' => 'state.school-admin.get', 'uses' => 'StateViewController@getSchoolAdminSignIn'])->where('state', '[a-z\-]+');

	Route::get('{state}/forgot-password', ['as' => 'state.forgotpassword.get', 'uses' => 'StateViewController@getForgotPassword']);

	Route::get('{state}/school/forgot-password', ['as' => 'state.forgotpassword.schooladmin', 'uses' => 'StateViewController@getForgotPasswordSchoolAdmin']);

	Route::get('{state}/password/reset/{token}', ['as' => 'state.resetpassword.get', 'uses' => 'StateViewController@getResetPassword']);

	Route::get('{state}/general-information', ['as' => 'state.general.information', 'uses' => 'StateViewController@getGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information/students', ['as' => 'state.student.general.information', 'uses' => 'StateViewController@getStudentGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information/schools', ['as' => 'state.school.general.information', 'uses' => 'StateViewController@getSchoolGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information/students/registered', ['as' => 'state.student.general.information.registered', 'uses' => 'StateViewController@getStudentRegisteredGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information/students/allotted', ['as' => 'state.student.general.information.allotted', 'uses' => 'StateViewController@getStudentAllottedGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information/students/enrolled', ['as' => 'state.student.general.information.enrolled', 'uses' => 'StateViewController@getStudentEnrolledGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information/students/rejected', ['as' => 'state.student.general.information.rejected', 'uses' => 'StateViewController@getStudentRejectedGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information/schools/registered', ['as' => 'state.school.general.information.registered', 'uses' => 'StateViewController@getSchoolRegisteredGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information/schools/rejected', ['as' => 'state.school.general.information.rejected', 'uses' => 'StateViewController@getSchoolRejectedGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information/schools/verified', ['as' => 'state.school.general.information.verified', 'uses' => 'StateViewController@getSchoolVerifiedGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information/schools/banned', ['as' => 'state.school.general.information.banned', 'uses' => 'StateViewController@getSchoolBannedGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information/schools/status', ['as' => 'state.school.general.information.status', 'uses' => 'StateViewController@getSchoolStatusGeneralInformation'])->where('state', '[a-z\-]+');

	Route::get('{state}/public-information/school_info', ['as' => 'state.public.information.school', 'uses' => 'StateViewController@publicInformationSchool'])->where('state', '[a-z\-]+');

	Route::get('{state}/general-information/student_status', ['as' => 'state.student.status.information.school', 'uses' => 'StateViewController@getStudentStatusGeneralInformation'])->where('state', '[a-z\-]+');

});

Route::group(['prefix' => 'api'], function () {

	Route::post('{state}/language/change', 'StateBaseController@postLanguageChange');

});