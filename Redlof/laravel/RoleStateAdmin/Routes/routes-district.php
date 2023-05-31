<?php

Route::group(['middleware' => ['role:role-state-admin', 'web'], 'namespace' => 'District'], function () {
	$districtview = 'DistrictViewController@';

	Route::get('stateadmin/districts', ['as' => 'stateadmin.district.get', 'uses' => $districtview . 'getDistrictView']);

	Route::get('stateadmin/district/brief/{district_id}', ['as' => 'stateadmin.district.brief', 'uses' => $districtview . 'getDistrictBriefView'])
		->where('district_admin_id', '[0-9]+');

	Route::get('stateadmin/districtadmin/{district_id}', ['as' => 'stateadmin.district.district-admin', 'uses' => $districtview . 'getDistrictAdminView'])
		->where('state', '[a-z\-]+');

	Route::get('stateadmin/districtadmin/{district_id}/blocks', ['as' => 'stateadmin.district.blocks', 'uses' => $districtview . 'getDistrictBlockView'])
		->where('state', '[a-z\-]+');

	Route::get('stateadmin/districtadmin/brief/{district_admin_id}', ['as' => 'stateadmin.districtadmin.brief', 'uses' => $districtview . 'getDistrictAdminBriefView'])
		->where('district_admin_id', '[0-9]+');

});

Route::group(array('prefix' => 'api/stateadmin', 'namespace' => 'District'), function () {

	$districtapi = 'DistrictController@';

	Route::get('districts/{state_id}', 'DistrictController@getDistricts')->where('state_id', '[0-9]+');

	Route::get('districts/{state_id}/search', 'DistrictController@getSearchDistricts')->where('state_id', '[0-9]+');

	Route::get('districts/{ditrict_id}/blocks', 'DistrictController@getDistrictBlocks')->where('state_id', '[0-9]+');

	Route::get('get/districts/{state_id}', 'DistrictController@getDistrictListing')->where('state_id', '[0-9]+');

	Route::post('district/add', $districtapi . 'postAddDistrict');

	Route::post('district/update/block/{block_id}/type/{block_type}', $districtapi . 'postUpdateBlockType');

	Route::get('districtadmin/{district_id}', 'DistrictController@getDistrictAdmins');

	Route::post('districtadmin/add', 'DistrictController@postDistrictAdmins');

	Route::post('district/deactivate/{district_id}', 'DistrictController@deactivateDistrict')->where('district_id', '[0-9]+');

	Route::post('districtadmin/deactivate/{district_id}', 'DistrictController@deactivateDistrictAdmin')->where('district_id', '[0-9]+');

});