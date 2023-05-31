<?php

Route::group(['middleware' => ['role:role-district-admin', 'web'], 'namespace' => 'Role'], function () {
    $c = 'RoleDistrictAdminViewController@';
    Route::get('districtadmin/nodaladmin', ['as' => 'districtadmin.nodal.nodal-admin', 'uses' => $c . 'getNodalView'])
        ->where('district', '[a-z\-]+');

    Route::get('districtadmin/nodaladmin/brief/{nodal_admin_id}', ['as' => 'districtadmin.nodaladmin.brief', 'uses' => $c . 'getNodalAdminBriefView'])
        ->where('nodal_admin_id', '[0-9]+');

    Route::get('districtadmin/{district_id}/deactivated-nodal-admins', ['as' => 'districtadmin.nodal.deactivated-nodal-admin', 'uses' => $c . 'getDeactivatedNodalView'])
        ->where('district_id', '[0-9]+');

    Route::get('districtadmin/bulk-upload', ['as' => 'districtadmin.nodal.bulk-upload', 'uses' => $c . 'getBulkView'])
        ->where('district', '[a-z\-]+');

});

Route::group(array('prefix' => 'api/districtadmin', 'namespace' => 'Role', 'middleware' => ['throttle:60,60']), function () {

    $nodalapi = 'RoleDistrictAdminNodalController@';

    Route::get('nodal', $nodalapi . 'getNodalAdmins');

    Route::get('get/districtnodaladmin', $nodalapi . 'getDistrictNodalAdmins');

    Route::post('add/nodaladmin', $nodalapi . 'postNodalAdmin');

    Route::post('add/bulk-udise', $nodalapi . 'postAddBulkUdise');

    Route::post('request/nodal/upload', $nodalapi . 'postRequestNodal');

    Route::get('nodaladmin/{district_id}', $nodalapi . 'getNodalAdminsList')->where('district_id', '[0-9]+');

    Route::get('nodaladmin/un-assigned/blocks/{nodal_admin_id}', $nodalapi . 'getNodalAdminsUnAssignedBlocksList');

    Route::post('nodaladmin/block/assign/{nodal_admin_id}', $nodalapi . 'postNodalAdminBlockAssign')->where('district_id', '[0-9]+');

    Route::get('nodaladmin/bulk/{district_id}', $nodalapi . 'getUdiseNodals')->where('district_id', '[0-9]+');
    Route::get('search/nodaladmin/bulk/{district_id}', $nodalapi . 'getSearchUdiseNodals')->where('district_id', '[0-9]+');

    Route::get('assign/nodaladmin/{district_id}', $nodalapi . 'getAssignNodalAdminsList')->where('district_id', '[0-9]+');
    //To update nodal admin status

    Route::post('nodal/deactivate/{nodal_id}', $nodalapi . 'deactivateNodalAdmin');

    Route::post('nodal/activate/{nodal_id}', $nodalapi . 'activateNodalAdmin');

    Route::get('get/districts/{state_id}', $nodalapi . 'getStateDistricts');

    Route::get('search/nodaladmin/{district_id}', $nodalapi . 'getSearchNodalAdmin')->where('district_id', '[0-9]+');

    Route::get('deactivated-nodal/{district_id}', $nodalapi . 'getDeactivatedNodals')->where('district_id', '[0-9]+');

    Route::post('nodal/unassign/block/{nodal_block_id}', $nodalapi . 'postUnAssignNodalBlock')->where('nodal_block_id', '[0-9]+');

});
