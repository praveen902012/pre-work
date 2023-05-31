<?php

// View Routes

Route::group([
	'middleware' => ['role:role-nodaladmin', 'web'],
	'prefix' => 'nodal',
	'namespace' => 'State'],
	function () {

		$c = 'StateViewController@';

		// STATE

		Route::get('states', ['as' => 'stateadmin.state.get', 'uses' => $c . 'getStates']);

		Route::get('states/brief/{state_id}', ['as' => 'stateadmin.state.brief', 'uses' => $c . 'getStateBriefView'])
			->where('state_id', '[0-9]+');

		Route::get('states/{state}', ['as' => 'stateadmin.state.single', 'uses' => $c . 'getStateSingleView'])
			->where('state', '[a-z\-]+');

		Route::get('stateadmins', ['as' => 'stateadmin.state.state-admin', 'uses' => $c . 'getStateAdminView']);

		// DISTRICT

		Route::get('states/{state}/districts', ['as' => 'stateadmin.role.district-admin', 'uses' => $c . 'getDistrictView'])
			->where('state', '[a-z\-]+');

		Route::get('states/districts/{state_id}', ['as' => 'stateadmin.single.district-admin', 'uses' => $c . 'getDistrictSingle']);

		// NODAL

		// Route::get('states/{state}/nodals', ['as' => 'stateadmin.nodal.nodal-admin', 'uses' => $c . 'getNodalView'])
		// 	->where('state', '[a-z\-]+');

		// SCHOOL

		Route::get('states/{state}/schools', ['as' => 'stateadmin.school.get', 'uses' => $c . 'getSchoolView'])
			->where('state', '[a-z\-]+');

		Route::get('school/{id}', ['as' => 'stateadmin.school.single', 'uses' => $c . 'getSchoolSingleView']);

	});