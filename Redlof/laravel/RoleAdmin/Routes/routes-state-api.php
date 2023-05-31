<?php

// API Routes

Route::group([
    'prefix' => 'api/admin',
    'namespace' => 'State'],

    function () {

        $c = 'StateController@';

        // State API

        Route::post('state/add', $c . 'postStateAdd');

        Route::post('state/add/locality', $c . 'postAddLocality');

        Route::post('state/add/block', $c . 'postAddBlock');

        Route::post('state/add/sub-block', $c . 'postAddSubBlock');

        Route::post('state/add/cluster', $c . 'postAddCluster');

        Route::post('download/locality/{block_id}', $c . 'downloadLocality');

        Route::post('download/block/{district_id}', $c . 'downloadBlock');

        Route::get('get/subblocks/{district_id}/type/{type}', $c . 'getSubBlocks');

        Route::get('locality/dependencies/{id}', $c . 'getLocalityDependency');

        Route::post('state/update/locality', $c . 'postUpdateLocality');

        Route::post('delete/locality/management', $c . 'postDeleteLocality');

        Route::post('reassign/locality/management', $c . 'postReassignLocality');

        Route::post('state/update', $c . 'postUpdateState');

        Route::get('states/get/all', $c . 'getStates');

        Route::get('states/all', $c . 'getStatesAll');

        Route::get('get/locality/{block_id}', $c . 'getLocalityAll');

        Route::get('states/all/search', $c . 'getSearchStatesAll');

        Route::get('get/states/newlist', $c . 'getNewStates');

        Route::get('get/states/all', $c . 'getAllStates');

        Route::get('get/districts/{state_id}', $c . 'getStateDistricts');

        Route::get('get/blocks/{district_id}', $c . 'getDistrictsBlocks');

        Route::get('state/details/{state_id}', $c . 'getStateDetails');

        Route::post('state/admin/add', $c . 'postAddStateAdmin');

        Route::get('statesadmin', $c . 'getStateAdminAll');

        Route::get('stateadmin/{state_id}', $c . 'getStateAdmins');

        Route::get('deactivated-stateadmin/{state_id}', $c . 'getDeactivatedStateAdmins');

        Route::get('stateadmin/search/{state_id}', $c . 'getSearchStateAdmins');

        Route::get('users/get/all', $c . 'getUsers');

        Route::post('state/delete/{state_id}', $c . 'postStateDelete')->where('state_id', '[0-9]+');

        Route::post('stateadmin/deactivate/{stateadmin_id}', $c . 'deactivateStateAdmin');

        Route::post('stateadmin/activate/{stateadmin_id}', $c . 'activateStateAdmin');

        Route::post('stateadmin/delete/{statadmin_id}', $c . 'stateAdminDelete')->where('statadmin_id', '[0-9]+');

        Route::post('state/admin/update', $c . 'UpdateStateAdmin');

        // School API

        Route::get('schools/{state_id}', $c . 'getSchool')->where('state_id', '[0-9]+');

        // Students API

        Route::get('students/{state_id}', $c . 'getStudents');

        Route::get('get/allotted-students/{state_id}', $c . 'getAllottedStudents');

        Route::get('get/enrolled-students/{state_id}', $c . 'getEnrolledStudents');

        Route::get('get/rejected-students/{state_id}', $c . 'getRejectedStudents');

        // District API

        Route::get('districtadmin/{district_id}', 'DistrictController@getDistrictAdmins');

        Route::get('deactivated-districtadmin/{district_id}', 'DistrictController@getDeactivatedDistrictAdmins');

        Route::get('districtadminlist/{district_id}', 'DistrictController@getDistrictAdminsList');

        Route::post('districtadmin/add', 'DistrictController@postDistrictAdmins');

        Route::get('districts/{state_id}', 'DistrictController@getDistricts')->where('state_id', '[0-9]+');

        Route::get('districts/search/{state_id}', 'DistrictController@getSearchDistricts');

        Route::get('districts/list/{state_id}', 'DistrictController@getDistrictsList');

        Route::post('district/add', 'DistrictController@postAddDistrict');

        Route::post('district/deactivate/{district_id}', 'DistrictController@deactivateDistrict')->where('district_id', '[0-9]+');

        Route::post('districtadmin/deactivate/{district_id}', 'DistrictController@deactivateDistrictAdmin')->where('district_id', '[0-9]+');

        Route::post('districtadmin/activate/{district_id}', 'DistrictController@activateDistrictAdmin')->where('district_id', '[0-9]+');

        Route::get('nodal/{district_id}', 'NodalController@getNodals');

        Route::get('nodal/search/{district_id}', 'NodalController@getSearchNodals');

        Route::get('deactivated-nodal/{district_id}', 'NodalController@getDeactivatedNodals');

        Route::post('nodaladmin/add', 'NodalController@postNodals');

        Route::post('nodal/delete/{nodal_id}', 'NodalController@NodalDelete')->where('nodal_id', '[0-9]+');

        Route::post('nodal/deactivate/{nodal_id}', 'NodalController@deactivateNodalAdmin');

        Route::post('nodal/activate/{nodal_id}', 'NodalController@activateNodalAdmin');

    });