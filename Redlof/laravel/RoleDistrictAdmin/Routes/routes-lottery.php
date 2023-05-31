<?php

Route::group(['middleware' => ['role:role-district-admin', 'web'], 'namespace' => 'Role'], function () {

	Route::get('districtadmin/lottery', ['as' => 'districtadmin.lottery', 'uses' => 'RoleDistrictAdminLotteryController@getLotteryView']);

});