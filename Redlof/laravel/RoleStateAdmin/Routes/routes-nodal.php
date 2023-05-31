<?php

Route::group(['middleware' => ['role:role-state-admin', 'web'], 'namespace' => 'Role'], function () {
	$c = 'RoleStateAdminViewController@';
	Route::get('states/nodaladmins', ['as' => 'stateadmin.nodal.nodal-admin', 'uses' => $c . 'getNodalView'])
		->where('state', '[a-z\-]+');

	Route::get('stateadmin/deactivated-nodal-admins/{state_id}', ['as' => 'stateadmin.nodal.deactivated-nodal-admin', 'uses' => $c . 'getDeactivatedNodalView'])
		->where('state_id', '[0-9]+');

	Route::get('stateadmin/nodaladmin/brief/{nodal_admin_id}', ['as' => 'stateadmin.nodaladmin.brief', 'uses' => $c . 'getNodalAdminBriefView'])
		->where('nodal_admin_id', '[0-9]+');

	Route::get('states/assign/blocks-nodaladmins', ['as' => 'stateadmin.block.nodal-admin', 'uses' => $c . 'getAssignBlockNodalAdminView'])
		->where('state', '[a-z\-]+');

	Route::get('states/manage/students', ['as' => 'stateadmin.manage-student', 'uses' => $c . 'getManageStudentsView'])
		->where('state', '[a-z\-]+');

});

Route::group(array('prefix' => 'api/stateadmin', 'namespace' => 'Role', 'middleware' => ['throttle:60,60']), function () {

	$nodalapi = 'RoleStateAdminNodalController@';

	Route::get('nodal', $nodalapi . 'getNodalAdmins');

	Route::get('district/nodal/admins/{district_id}', $nodalapi . 'getDistrictNodalAdmins');

	Route::post('add/nodaladmin', $nodalapi . 'addNodalAdmin');

	//To update nodal admin status

	Route::post('nodal/deactivate/{nodal_id}', $nodalapi . 'deactivateNodalAdmin');

	Route::get('get/district/blocks/{district_id}', $nodalapi . 'getDistrictBlocks');

	Route::post('block-nodaladmin/assign', $nodalapi . 'postBulkAssignBlockToNodalAdmin');

	Route::post('nodal/activate/{nodal_id}', $nodalapi . 'activateNodalAdmin');

	Route::get('deactivated-nodal/{state_id}', $nodalapi . 'getDeactivatedNodals')->where('state_id', '[0-9]+');

	Route::get('nodal/search/all', $nodalapi . 'searchNodalAdmins');

	Route::get('deactivated-nodal/search/all', $nodalapi . 'searchDeactivatedNodals');

});
