<?php

// View Routes

Route::group([
	'middleware' => ['role:role-admin', 'web'],
	'prefix' => 'admin',
	'namespace' => 'Student'],
	function () {

		$c = 'StudentViewController@';

		Route::get('students', ['as' => 'admin.students.get', 'uses' => $c . 'getStudents']);

	});

// API Routes

Route::group([
	'middleware' => ['throttle:60,60'],
	'prefix' => 'api/admin',
	'namespace' => 'Student'],

	function () {

		$c = 'StudentController@';

		Route::get('get/students/all', $c . 'getStudents');
		Route::get('search/students/{state_id}', $c . 'getSearchStudents');

	});