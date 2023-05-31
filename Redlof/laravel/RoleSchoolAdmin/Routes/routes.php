<?php

Route::group(array('prefix' => 'api/schooladmin', 'namespace' => 'Role'), function () {
	Route::post('signin', 'AccessController@postSignIn');
});

Route::group(['middleware' => ['role:role-school-admin']], function () {
	Route::group(array('namespace' => 'Role'), function () {
		Route::get('partial/schooladmin/include/{slug}', ['uses' => 'PartialController@getInclude']);
		Route::get('partial/schooladmin/{slug}', ['uses' => 'PartialController@getPage']);
		Route::get('popup/schooladmin/{slug}', ['uses' => 'PartialController@getPopup']);
	});

	Route::group(array('prefix' => 'api/schooladmin', 'namespace' => 'Role', 'middleware' => ['throttle:45,60']), function () {

		Route::post('password/change', 'RoleSchoolAdminController@postChangePassword');
		Route::post('photo', 'RoleSchoolAdminController@postUpdatePhoto');
		Route::post('profile/update', 'RoleSchoolAdminController@postUpdateProfile');
		Route::get('information/get ', 'RoleSchoolAdminController@getAdminInformation');
		Route::get('get/applicationcycle', 'RoleSchoolAdminController@getApplicationCycleListing');
		Route::post('apply-filter/school-details', 'RoleSchoolAdminController@applySchoolFilter');

		Route::post('edit/previous/school', 'RoleSchoolAdminController@editPreviousSchool');


	});
});

Route::group(['middleware' => ['role:role-school-admin', 'web'], 'namespace' => 'Role'], function () {

	Route::get('schooladmin/dashboard', ['as' => 'schooladmin.dashboard', 'uses' => 'RoleSchoolAdminViewController@getDashboardView']);

	Route::get('schooladmin/profile', ['as' => 'schooladmin.profile', 'uses' => 'RoleSchoolAdminViewController@getProfileView']);

	Route::get('schooladmin/profile/update', ['as' => 'schooladmin.profile-update', 'uses' => 'RoleSchoolAdminViewController@getProfileUpdateView']);

	Route::get('schooladmin/profile/update-photo', ['as' => 'schooladmin.profile-update-photo', 'uses' => 'RoleSchoolAdminViewController@getProfileUpdatePhotoView']);

	Route::get('schooladmin/profile/change-password', ['as' => 'schooladmin.change-password', 'uses' => 'RoleSchoolAdminViewController@getChangePasswordView']);

	Route::get('schooladmin/members', ['as' => 'schooladmin.members.get', 'uses' => 'RoleSchoolAdminViewController@getMemberView']);

	Route::get('schooladmin/interests', ['as' => 'schooladmin.interests.get', 'uses' => 'RoleSchoolAdminViewController@getInterestsView']);

	Route::get('schooladmin/countries', ['as' => 'schooladmin.countries.get', 'uses' => 'RoleSchoolAdminViewController@getCountriesView']);

	Route::get('schooladmin/states', ['as' => 'schooladmin.states.get', 'uses' => 'RoleSchoolAdminViewController@getSatesView']);

	Route::get('schooladmin/cities', ['as' => 'schooladmin.cities.get', 'uses' => 'RoleSchoolAdminViewController@getCitiesView']);

	Route::get('schooladmin/degrees', ['as' => 'schooladmin.degrees.get', 'uses' => 'RoleSchoolAdminViewController@getDegreesView']);

	Route::get('schooladmin/add-fee-structure', ['as' => 'schooladmin.add-fee-structure', 'uses' => 'RoleSchoolAdminViewController@getAddFeeStructureView']);

	Route::get('schooladmin/add-seat-structure', ['as' => 'schooladmin.add-seat-structure', 'uses' => 'RoleSchoolAdminViewController@getAddSeatStructureView']);

	Route::get('schooladmin/edit-school', ['as' => 'schooladmin.edit-school', 'uses' => 'RoleSchoolAdminViewController@getEditSchoolView']);

	Route::get('schooladmin/update-address/{udise}', ['as' => 'schooladmin.update-address', 'uses' => 'RoleSchoolAdminViewController@getUpdateAddressView']);

	Route::get('schooladmin/update-region/{udise}', ['as' => 'schooladmin.update-region', 'uses' => 'RoleSchoolAdminViewController@getUpdateRegionView']);

	Route::get('schooladmin/update-fee/{udise}', ['as' => 'schooladmin.update-fee', 'uses' => 'RoleSchoolAdminViewController@getUpdateFeeView']);

	Route::get('schooladmin/update-bank/{udise}', ['as' => 'schooladmin.update-bank', 'uses' => 'RoleSchoolAdminViewController@getUpdateBankView']);

	Route::get('schooladmin/school-primary', ['as' => 'schooladmin.school-profile-primary', 'uses' => 'RoleSchoolAdminViewController@getProfilePrimaryView']);

	Route::get('schooladmin/school-address', ['as' => 'schooladmin.school-profile-address', 'uses' => 'RoleSchoolAdminViewController@getProfileAddressView']);

	Route::get('schooladmin/school-region', ['as' => 'schooladmin.school-profile-region', 'uses' => 'RoleSchoolAdminViewController@getProfileRegionView']);

	Route::get('schooladmin/school-fee', ['as' => 'schooladmin.school-profile-fee', 'uses' => 'RoleSchoolAdminViewController@getProfileFeeView']);

	Route::get('schooladmin/school-bank', ['as' => 'schooladmin.school-profile-bank', 'uses' => 'RoleSchoolAdminViewController@getProfileBankView']);

});