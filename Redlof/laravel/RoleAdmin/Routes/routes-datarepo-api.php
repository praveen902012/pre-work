
<?php

Route::group([
	'middleware' => ['throttle:60,60'],
	'prefix' => 'api/admin',
	'namespace' => 'DataRepo'],

	function () {

// API Languages

		$c = 'DataRepoController@';

		Route::get('get/languages/all', $c . 'getLanguages');

		Route::get('get/languages/search', $c . 'getSearchedLanguages');

		Route::get('get/languages/list', $c . 'getLanguagesList');

		Route::post('language/add', $c . 'postLanguagesAdd');
	});