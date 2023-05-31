<?php

Route::group(['middleware' => ['role:role-state-admin', 'web'], 'namespace' => 'Setting'], function () {

	Route::get('stateadmin/setting', ['as' => 'stateadmin.setting', 'uses' => 'SettingController@getsettingView']);

});

