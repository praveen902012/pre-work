<?php

Route::group(array('prefix' => 'api/stateadmin', 'namespace' => 'Role'), function () {
	Route::post('signin', 'AccessController@postSignIn');
});

Route::group(['middleware' => ['role:role-state-admin']], function () {
	Route::group(array('namespace' => 'Role'), function () {
		Route::get('partial/stateadmin/include/{slug}', ['uses' => 'PartialController@getInclude']);
		Route::get('partial/stateadmin/{slug}', ['uses' => 'PartialController@getPage']);
		Route::get('popup/stateadmin/{slug}', ['uses' => 'PartialController@getPopup']);
	});

	Route::group(array('prefix' => 'api/stateadmin', 'namespace' => 'Role'), function () {
		Route::post('dashboard/data/get ', 'RoleStateAdminController@getAdminDashboardInfo');

		Route::post('password/change', 'RoleStateAdminController@postChangePassword');
		Route::post('photo', 'RoleStateAdminController@postUpdatePhoto');
		Route::post('profile/update', 'RoleStateAdminController@postUpdateProfile');
		Route::get('information/get ', 'RoleStateAdminController@getAdminInformation');

		Route::get('get/applicationcycle', 'RoleStateAdminController@getApplicationCycleListing');
		Route::get('get/district/list', 'RoleStateAdminController@getDistrictListing');
		Route::get('get/nodal/{district_id}/list', 'RoleStateAdminController@getNodalListing');
		Route::get('get/schools/{district_id}/list', 'RoleStateAdminController@getSchoolListing');

		Route::get('get/schoolinfo/application_cycle_year/{application_id}/district_id/{district_id}/nodal_id/{nodal_id}/{cache?}', 'RoleStateAdminController@getSchoolInfo');

		Route::post('apply-filter/student-details/{cache?}', 'RoleStateAdminController@applyFilterStudentDetails');

		Route::post('apply-filter/overview-metrics', 'RoleStateAdminController@applyFilterOverviewMetrics');

		Route::get('get/class/list', 'RoleStateAdminController@getClassListing');

	});
});

Route::group(['middleware' => ['role:role-state-admin', 'web'], 'prefix' => 'stateadmin', 'namespace' => 'Role'], function () {

	Route::get('dashboard', ['as' => 'stateadmin.dashboard', 'uses' => 'RoleStateAdminViewController@getDashboardView']);

	Route::get('profile', ['as' => 'stateadmin.profile', 'uses' => 'RoleStateAdminViewController@getProfileView']);

	Route::get('profile/update', ['as' => 'stateadmin.profile-update', 'uses' => 'RoleStateAdminViewController@getProfileUpdateView']);

	Route::get('profile/update-photo', ['as' => 'stateadmin.profile-update-photo', 'uses' => 'RoleStateAdminViewController@getProfileUpdatePhotoView']);

	Route::get('profile/change-password', ['as' => 'stateadmin.change-password', 'uses' => 'RoleStateAdminViewController@getChangePasswordView']);

});