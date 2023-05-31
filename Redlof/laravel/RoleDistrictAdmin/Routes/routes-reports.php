<?php

// View Routes

Route::group([
    'middleware' => ['role:role-district-admin', 'web'],
    'prefix' => 'districtadmin',
    'namespace' => 'Reports'],
    function () {

        $c = 'ReportViewController@';

        // GALLERY

        Route::get('reports', ['as' => 'districtadmin.reports', 'uses' => $c . 'getReportsView']);

    });

Route::group([
    'middleware' => ['throttle:60,60'],
    'prefix' => 'api/districtadmin/reports',
    'namespace' => 'Reports'],

    function () {

        $c = 'ReportController@';

        Route::get('session-year', $c . 'getSessionYearStats');

    });
