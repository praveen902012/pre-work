<?php

Route::group(['middleware' => ['role:role-admin', 'web'], 'prefix' => 'admin', 'namespace' => 'School'], function () {

	$schoolview = 'SchoolViewController@';

});

Route::group(array('prefix' => 'api/admin', 'namespace' => 'School', 'middleware' => ['throttle:60,60']), function () {

	$schoolapi = 'SchoolController@';

	Route::get('get/schools/all', $schoolapi . 'getSchoolsAll');

	Route::get('schools/search', $schoolapi . 'getSearchedSchools');

	Route::post('school/add', $schoolapi . 'postSchoolAdd');

	Route::post('school/delete/{school_id}', $schoolapi . 'postSchoolDelete')->where('school_id', '[0-9]+');

	Route::post('school/update', $schoolapi . 'postSchoolUpdate');

	Route::post('school/admin/add', $schoolapi . 'postAddSchoolAdmin');

	Route::get('search/district/{state_id}/{keyword}', $schoolapi . 'getDistricts')->where('state_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

	Route::get('search/block/{district_id}/{keyword}', $schoolapi . 'searchBlock')->where('district_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

	Route::get('search/locality/{block_id}/{keyword}', $schoolapi . 'searchLocality')->where('block_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

	Route::get('search/sublocality/{locality_id}/{keyword}', $schoolapi . 'searchSubLocality')->where('locality_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

	Route::get('search/subsublocality/{sub_locality_id}/{keyword}', $schoolapi . 'searchSubSubLocality')->where('sub_locality_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

});