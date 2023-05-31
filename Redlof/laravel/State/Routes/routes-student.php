<?php

Route::group(array('prefix' => 'api', 'namespace' => 'Student'), function () {
	$c = 'StudentController@';

	Route::get('{state_id}/general-information/students/registered/{selected_cycle}', $c . 'getRegisteredStudent')->where('state_id', '[0-9]+');

	Route::get('{state_id}/general-information/students/allotted/{selected_cycle}', $c . 'getAllottedStudent')->where('state_id', '[0-9]+');

	Route::get('{state_id}/general-information/students/enrolled/{selected_cycle}', $c . 'getEnrolledStudent')->where('state_id', '[0-9]+');

	Route::get('{state_id}/general-information/students/rejected/{selected_cycle}', $c . 'getRejectedStudent')->where('state_id', '[0-9]+');

	Route::get('{state_id}/general-information/students/registered/{selected_cycle}/search', $c . 'searchRegisteredStudent')->where('state_id', '[0-9]+');

	Route::get('{state_id}/general-information/students/allotted/{selected_cycle}/search', $c . 'searchAllottedStudent')->where('state_id', '[0-9]+');

	Route::get('{state_id}/general-information/students/enrolled/{selected_cycle}/search', $c . 'searchEnrolledStudent')->where('state_id', '[0-9]+');

	Route::get('{state_id}/general-information/students/rejected/{selected_cycle}/search', $c . 'searchRejectedStudent')->where('state_id', '[0-9]+');

	Route::get('{state_id}/applicationcycle/get', $c . 'getApplicationCycle')->where('state_id', '[0-9]+');
	
	Route::get('{state_id}/student/search', $c . 'SearchForStudent')->where('state_id', '[0-9]+');

	Route::get('{state_id}/student/searchByName', $c . 'SearchForStudentByName')->where('state_id', '[0-9]+');
	
});