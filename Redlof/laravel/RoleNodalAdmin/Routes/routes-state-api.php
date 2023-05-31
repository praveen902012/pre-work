<?php

// API Routes

Route::group([
	'middleware' => ['throttle:60,60'],
	'prefix' => 'api/nodaladmin',
	'namespace' => 'State'],

	function () {

		$c = 'StateController@';

		// State API

		Route::get('states/get/all', $c . 'getStates');

		Route::get('search/district/{state_id}/{keyword}', $c . 'getDistricts')->where('state_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

		Route::get('search/block/{district_id}/{keyword}', $c . 'searchBlock')->where('district_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

		Route::get('search/locality/{block_id}/{keyword}', $c . 'searchLocality')->where('block_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

		Route::get('search/sublocality/{locality_id}/{keyword}', $c . 'searchSubLocality')->where('locality_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

		Route::get('search/subsublocality/{sub_locality_id}/{keyword}', $c . 'searchSubSubLocality')->where('sub_locality_id', '[0-9]+')->where('keyword', '[0-9a-zA-Z\-]+');

	});