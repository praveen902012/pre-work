<?php

// View Routes

Route::group([
	'middleware' => ['role:role-admin', 'web'],
	'prefix' => 'admin',
	'namespace' => 'DataRepo'],
	function () {

		$c = 'DataRepoViewController@';

		Route::get('language/all', ['as' => 'admin.language.all', 'uses' => $c . 'Languageall']);

	});