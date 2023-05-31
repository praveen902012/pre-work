<?php

// View Routes

Route::group([
    'middleware' => ['role:role-state-admin', 'web'],
    'prefix' => 'stateadmin',
    'namespace' => 'Reports'],
    function () {

        $c = 'ReportViewController@';

        // GALLERY

        Route::get('reports', ['as' => 'stateadmin.reports', 'uses' => $c . 'getReportsView']);

    });

Route::group([
    'middleware' => ['throttle:60,60'],
    'prefix' => 'api/stateadmin/reports',
    'namespace' => 'Reports'],

    function () {

        $c = 'ReportController@';

        Route::get('session-year', $c . 'getSessionYearStats');

        Route::post('download', $c . 'getDownoadReports');

    });
