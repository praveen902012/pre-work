<?php

Route::group(['prefix' => 'redlof', 'namespace' => 'WorkflowSQLQuery'], function () {

    $c = 'WorkflowSQLQueryController@';

    Route::post('workflow/start', ['uses' => $c . 'createWorkflow']);

    Route::get('workflow/fetch', ['uses' => $c . 'fetchWorkflow']);

    Route::get('workflow/stop', ['uses' => $c . 'stopWorkflow']);

});
