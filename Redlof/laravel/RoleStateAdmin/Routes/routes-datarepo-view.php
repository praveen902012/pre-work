<?php

// View Routes

Route::group([
	'middleware' => ['role:role-district-admin', 'web'],
	'prefix' => 'districtadmin',
	'namespace' => 'DataRepo'],
	function () {

		$c = 'DataRepoViewController@';

		Route::get('language/all', ['as' => 'nodaladmin.language.all', 'uses' => $c . 'Languageall']);

	});