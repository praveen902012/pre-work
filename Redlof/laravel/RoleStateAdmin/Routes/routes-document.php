<?php

// View Routes

Route::group([
	'middleware' => ['role:role-state-admin', 'web'],
	'prefix' => 'stateadmin',
	'namespace' => 'Role'],
	function () {
		
		Route::get('documents/all', ['as' => 'stateadmin.documents', 'uses' => 'RoleStateAdminViewController@getDocumentsView']);
	   
	});

// Route::group([
// 	'middleware' => ['role:role-state-admin', 'web'],
// 	'prefix' => 'popup/stateadmin',
// 	'namespace' => 'Role'],
// 	function () {
		
// 		Route::get('documents/update/{id}', ['as' => 'stateadmin.documents.update', 'uses' => 'RoleStateAdminViewController@getDocumentUpdatePopup']);
	
// 	});

Route::group([
	'middleware' => ['throttle:60,60'],
	'prefix' => 'api/stateadmin',
	'namespace' => 'State'],

	function () {

		$c = 'StateController@';

		Route::post('document/upload', $c . 'postAddDocument');
		Route::post('uploaded/document/delete/{id}', $c . 'postDocumentDelete');

	});