<?php

Route::group(['middleware' => ['role:role-state-admin']], function () {

	Route::group(array('prefix' => 'api/stateadmin', 'namespace' => 'Message', 'middleware' => ['throttle:45,60']), function () {

		Route::post('message/send/students ', 'MessageController@postSendStudentMessage');

	});
});

Route::group(['middleware' => ['role:role-state-admin', 'web'], 'prefix' => 'stateadmin', 'namespace' => 'Message'], function () {

	Route::get('send/message/students', ['as' => 'stateadmin.message.student', 'uses' => 'MessageViewController@getStudentMessageView']);

});