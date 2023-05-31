<?php

// View Routes

Route::group([
	'middleware' => ['role:role-nodal-admin', 'web'],
	'prefix' => 'nodaladmin',
	'namespace' => 'DataRepo'],
	function () {

		$c = 'DataRepoViewController@';

		Route::get('language/all', ['as' => 'nodaladmin.language.all', 'uses' => $c . 'Languageall']);

	});