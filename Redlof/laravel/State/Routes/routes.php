<?php

Route::group(['middleware' => ['web']], function () {
	Route::group(array('namespace' => 'Role'), function () {

		Route::get('partial/state/include/{slug}', ['uses' => 'PartialController@getInclude']);

		Route::get('partial/state/{slug}', ['uses' => 'PartialController@getPage']);

		Route::get('popup/state/{slug}', ['uses' => 'PartialController@getPopup']);
	});

});