<?php

Route::group(array('prefix' => 'api', 'namespace' => 'Gallery'), function () {

	Route::get('gallery/featured/{state_id}', 'GalleryController@getFeaturedGallery')->where('state_id', '[0-9]+');

	Route::get('gallery/all/{state_id}', 'GalleryController@getStateGallery')->where('state_id', '[0-9]+');

	Route::get('allottment/update', 'GalleryController@postUpdateAllottment');

});