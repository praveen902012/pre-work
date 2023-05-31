<?php

Route::group(['prefix' => 'redlof', 'namespace' => 'DatabaseQuery'], function () {

    $c = 'DatabaseQueryController@';

    Route::post('model-query', ['uses' => $c . 'getDatabaseQueryResult']);

});
