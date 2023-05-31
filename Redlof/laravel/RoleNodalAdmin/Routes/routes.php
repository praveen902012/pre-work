<?php

Route::group(array('prefix' => 'api/nodaladmin', 'namespace' => 'Role'), function () {
	Route::post('signin', 'AccessController@postSignIn');
});

Route::group(['middleware' => ['role:role-nodal-admin']], function () {

	Route::group(array('namespace' => 'Role'), function () {

		Route::get('partial/nodaladmin/include/{slug}', ['uses' => 'PartialController@getInclude']);
		Route::get('partial/nodaladmin/{slug}', ['uses' => 'PartialController@getPage']);
		Route::get('popup/nodaladmin/{slug}', ['uses' => 'PartialController@getPopup']);
	});

	Route::group(array('prefix' => 'api/nodaladmin', 'namespace' => 'Role', 'middleware' => ['throttle:45,60']), function () {

		Route::post('dashboard/data/get ', 'RoleNodalAdminController@getAdminDashboardInfo');

		Route::post('password/change', 'RoleNodalAdminController@postChangePassword');

		Route::post('photo', 'RoleNodalAdminController@postUpdatePhoto');

		Route::post('profile/update', 'RoleNodalAdminController@postUpdateProfile');

		Route::get('information/get ', 'RoleNodalAdminController@getAdminInformation');

		Route::post('add/udise', 'RoleNodalAdminController@postAddUdise');

		Route::post('add/bulk-udise', 'RoleNodalAdminController@postAddBulkUdise');

		Route::get('get/udise', 'RoleNodalAdminController@getAllUdise');

		Route::get('get/udise/pending', 'RoleNodalAdminController@getAllPendingUdise');

		Route::get('get/applicationcycle', 'RoleNodalAdminController@getApplicationCycleListing');

		Route::get('get/schools/{nodal_id}/list', 'RoleNodalAdminController@getSchoolListing');

		Route::get('get/schoolinfo/application_cycle_year/{application_id}/district_id/{district_id}/nodal_id/{nodal_id}/{cache?}', 'RoleNodalAdminController@getSchoolInfo');

		Route::post('apply-filter/student-details/{cache?}', 'RoleNodalAdminController@applyFilterStudentDetails');

		Route::post('apply-filter/overview-metrics', 'RoleNodalAdminController@applyFilterOverviewMetrics');

		Route::get('get/class/list', 'RoleNodalAdminController@getClassListing');

	});
});

Route::group(['middleware' => ['role:role-nodal-admin', 'web'], 'namespace' => 'Role'], function () {

	Route::get('nodaladmin/dashboard', ['as' => 'nodaladmin.dashboard', 'uses' => 'RoleNodalAdminViewController@getDashboardView']);

	Route::get('nodaladmin/profile', ['as' => 'nodaladmin.profile', 'uses' => 'RoleNodalAdminViewController@getProfileView']);

	Route::get('nodaladmin/profile/update', ['as' => 'nodaladmin.profile-update', 'uses' => 'RoleNodalAdminViewController@getProfileUpdateView']);

	Route::get('nodaladmin/profile/update-photo', ['as' => 'nodaladmin.profile-update-photo', 'uses' => 'RoleNodalAdminViewController@getProfileUpdatePhotoView']);

	Route::get('nodaladmin/profile/change-password', ['as' => 'nodaladmin.change-password', 'uses' => 'RoleNodalAdminViewController@getChangePasswordView']);

	Route::get('nodaladmin/profile/change-password', ['as' => 'nodaladmin.change-password', 'uses' => 'RoleNodalAdminViewController@getChangePasswordView']);

	Route::get('nodaladmin/upload-udise', ['as' => 'nodaladmin.udise.upload', 'uses' => 'RoleNodalAdminViewController@getUploadUdiseView']);

	Route::get('nodaladmin/pending-upload-udise', ['as' => 'nodaladmin.udise.pending', 'uses' => 'RoleNodalAdminViewController@getPendingUdiseView']);

});
