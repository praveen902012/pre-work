<?php

// View Routes

Route::group([
	'middleware' => ['role:role-state-admin', 'web'],
	'prefix' => 'stateadmin',
	'namespace' => 'State'],
	function () {

		$c = 'StateViewController@';

		// GALLERY

		Route::get('gallery', ['as' => 'stateadmin.state.gallery', 'uses' => $c . 'getGalleryView']);

		Route::get('featured-gallery', ['as' => 'stateadmin.state.featured-gallery', 'uses' => $c . 'getFeaturedGalleryView']);

	});

Route::group([
	'middleware' => ['throttle:60,60'],
	'prefix' => 'api/stateadmin',
	'namespace' => 'State'],

	function () {

		$c = 'StateController@';

		Route::get('gallery', $c . 'getGallery');

		Route::post('gallery/addImage/{state_id}', $c . 'postAddImage');

		Route::post('save/featured/images', $c . 'postSaveFeaturedImage');

		Route::get('featured-gallery', $c . 'getFeaturedGallery');

		Route::post('gallery/addFeaturedImage/{state_id}', $c . 'postAddFeaturedImage');

		Route::post('gallery/delete/{image_id}', $c . 'postDeleteImage')->where('image_id', '[0-9]+');
	});