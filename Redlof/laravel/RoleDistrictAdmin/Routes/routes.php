<?php

Route::group(array('prefix' => 'api/districtadmin', 'namespace' => 'Role'), function () {
	Route::post('signin', 'AccessController@postSignIn');
});

Route::group(['middleware' => ['role:role-district-admin']], function () {
	Route::group(array('namespace' => 'Role'), function () {
		Route::get('partial/districtadmin/include/{slug}', ['uses' => 'PartialController@getInclude']);
		Route::get('partial/districtadmin/{slug}', ['uses' => 'PartialController@getPage']);
		Route::get('popup/districtadmin/{slug}', ['uses' => 'PartialController@getPopup']);
	});

	Route::group(array('prefix' => 'api/districtadmin', 'namespace' => 'Role', 'middleware' => ['throttle:45,60']), function () {

		Route::post('password/change', 'RoleDistrictAdminController@postChangePassword');
		Route::post('photo', 'RoleDistrictAdminController@postUpdatePhoto');
		Route::post('profile/update', 'RoleDistrictAdminController@postUpdateProfile');
		Route::get('information/get ', 'RoleDistrictAdminController@getAdminInformation');

		Route::get('get/applicationcycle', 'RoleDistrictAdminController@getApplicationCycleListing');
		Route::get('get/district/list', 'RoleDistrictAdminController@getDistrictListing');
		Route::get('get/nodal/{district_id}/list', 'RoleDistrictAdminController@getNodalListing');
		Route::get('get/schools/{district_id}/list', 'RoleDistrictAdminController@getSchoolListing');

		Route::get('get/schoolinfo/application_cycle_year/{application_id}/district_id/{district_id}/nodal_id/{nodal_id}/{cache?}', 'RoleDistrictAdminController@getSchoolInfo');

		Route::post('apply-filter/student-details/{cache?}', 'RoleDistrictAdminController@applyFilterStudentDetails');

		Route::post('apply-filter/overview-metrics', 'RoleDistrictAdminController@applyFilterOverviewMetrics');

		Route::get('get/class/list', 'RoleDistrictAdminController@getClassListing');

	});
});

Route::group(['middleware' => ['role:role-district-admin', 'web'], 'namespace' => 'Role'], function () {

	Route::get('districtadmin/dashboard', ['as' => 'districtadmin.dashboard', 'uses' => 'RoleDistrictAdminViewController@getDashboardView']);

	Route::get('districtadmin/profile', ['as' => 'districtadmin.profile', 'uses' => 'RoleDistrictAdminViewController@getProfileView']);

	Route::get('districtadmin/profile/update', ['as' => 'districtadmin.profile-update', 'uses' => 'RoleDistrictAdminViewController@getProfileUpdateView']);

	Route::get('districtadmin/profile/update-photo', ['as' => 'districtadmin.profile-update-photo', 'uses' => 'RoleDistrictAdminViewController@getProfileUpdatePhotoView']);

	Route::get('districtadmin/profile/change-password', ['as' => 'districtadmin.change-password', 'uses' => 'RoleDistrictAdminViewController@getChangePasswordView']);

	Route::get('districtadmin/members', ['as' => 'districtadmin.members.get', 'uses' => 'RoleDistrictAdminViewController@getMemberView']);

	Route::get('districtadmin/interests', ['as' => 'districtadmin.interests.get', 'uses' => 'RoleDistrictAdminViewController@getInterestsView']);

	Route::get('districtadmin/countries', ['as' => 'districtadmin.countries.get', 'uses' => 'RoleDistrictAdminViewController@getCountriesView']);

	Route::get('districtadmin/states', ['as' => 'districtadmin.states.get', 'uses' => 'RoleDistrictAdminViewController@getSatesView']);

	Route::get('districtadmin/cities', ['as' => 'districtadmin.cities.get', 'uses' => 'RoleDistrictAdminViewController@getCitiesView']);

	Route::get('districtadmin/degrees', ['as' => 'districtadmin.degrees.get', 'uses' => 'RoleDistrictAdminViewController@getDegreesView']);

});