
<?php

Route::group([
	'middleware' => ['throttle:60,60'],
	'prefix' => 'api/nodaladmin',
	'namespace' => 'DataRepo'],

	function () {

// API Languages

		$c = 'DataRepoController@';

		Route::get('get/languages/all', $c . 'getLanguages');

		Route::get('get/languages/list', $c . 'getLanguagesList');

	});