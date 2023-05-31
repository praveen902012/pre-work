<?php

Route::group(array('namespace' => 'Role'), function () {

	Route::get('dynamic/content/admin/{name}', ['uses' => 'PartialController@getDynamicContent']);
});

Route::group(array('prefix' => 'api/admin', 'namespace' => 'Role'), function () {
	Route::post('signin', 'AccessController@postSignIn');
});

Route::group(['middleware' => ['role:role-admin']], function () {
	Route::group(array('namespace' => 'Role'), function () {

		Route::get('partial/admin/include/{slug}', ['uses' => 'PartialController@getInclude']);

		Route::get('partial/admin/{slug}', ['uses' => 'PartialController@getPage']);

		Route::get('popup/admin/{slug}', ['uses' => 'PartialController@getPopup']);
	});

	Route::group(array('prefix' => 'api/admin', 'namespace' => 'Role', 'middleware' => ['throttle:45,60']), function () {

		Route::post('dashboard/data/get ', 'RoleAdminController@getAdminDashboardInfo');

		Route::post('password/change', 'RoleAdminController@postChangePassword');

		Route::post('photo', 'RoleAdminController@postUpdatePhoto');

		Route::post('profile/update', 'RoleAdminController@postUpdateProfile');

		Route::get('information/get ', 'RoleAdminController@getAdminInformation');

	});

});

Route::group([
	'middleware' => ['role:role-admin', 'web'],
	'prefix' => 'admin',
	'namespace' => 'Role'],

	function () {

		$c = 'RoleAdminViewController@';

		Route::get('dashboard', ['as' => 'admin.dashboard', 'uses' => $c . 'getDashboardView']);

		Route::get('profile', ['as' => 'admin.profile', 'uses' => $c . 'getProfileView']);

		Route::get('profile/update', ['as' => 'admin.profile-update', 'uses' => $c . 'getProfileUpdateView']);

		Route::get('profile/update-photo', ['as' => 'admin.profile-update-photo', 'uses' => $c . 'getProfileUpdatePhotoView']);

		Route::get('profile/change-password', ['as' => 'admin.change-password', 'uses' => $c . 'getChangePasswordView']);

		Route::get('members', ['as' => 'admin.members.get', 'uses' => $c . 'getMemberView']);

		Route::get('languages', ['as' => 'admin.languages.get', 'uses' => $c . 'getLanguagesView']);

	});