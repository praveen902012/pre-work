<?php

Route::group(['prefix' => 'redlof', 'namespace' => 'Log'], function () {

    $c = 'LogController@';

    Route::get('log-list', ['uses' => $c . 'getLogList']);

    Route::get('log/{log_name}/single', ['uses' => $c . 'getLogSingle']);

});
