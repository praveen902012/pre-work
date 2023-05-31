<?php

Route::group(['middleware' => ['role:role-state-admin', 'web'], 'prefix' => 'api/stateadmin', 'namespace' => 'Notification'], function () {

    Route::get('users/search', ['uses' => 'NotificationController@getSearchUsers']);
    
    Route::get('users/filter', ['uses' => 'NotificationController@getFilterUsers']);

    Route::post('notification/popup/add', ['uses' => 'NotificationController@postPopupUsers']);
    
    Route::post('notification/email/add', ['uses' => 'NotificationController@postEmailNotifications']);
    
    Route::post('notification/browser/add', ['uses' => 'NotificationController@postBrowserNotifications']);
    
    Route::post('notification/sms/add', ['uses' => 'NotificationController@postSMSNotifications']);
 
    Route::post('notification/push/add', ['uses' => 'NotificationController@postPushNotifications']);

    Route::post('notification/image/upload', ['uses' => 'NotificationController@postPingToImageUpload']);

    Route::get('notification/image/get', ['uses' => 'NotificationController@getPingToImages']);

    Route::get('notification/get/school_count', ['uses' => 'NotificationController@getSchoolCount']);

    Route::get('notification/get/student_count', ['uses' => 'NotificationController@getStudentCount']);

    Route::get('notification/get/school-admin', ['uses' => 'NotificationController@getSchoolAdmin']);

    Route::post('notification/notification/sms/add-for-student', ['uses' => 'NotificationController@postSMSNotificationsForStudent']);

});

Route::group(array('middleware' => ['role:role-state-admin', 'web'], 'prefix' => 'stateadmin', 'namespace' => 'Notification'), function () {

    Route::get('notifications/popup', ['as' => 'stateadmin.notifications-popup', 'uses' => 'NotificationViewController@getPopupNotifications']);

    Route::get('notifications/desktop', ['as' => 'stateadmin.notifications-desktop', 'uses' => 'NotificationViewController@getDesktopNotifications']);

    Route::get('notifications', ['as' => 'stateadmin.notifications-all', 'uses' => 'NotificationViewController@getNotifications']);

    Route::get('notifications/sms', ['as' => 'stateadmin.notifications-sms', 'uses' => 'NotificationViewController@getSmsNotifications']);

    Route::get('notifications/mail', ['as' => 'stateadmin.notifications-mail', 'uses' => 'NotificationViewController@getMailNotifications']);

    Route::get('notifications/push', ['as' => 'stateadmin.notifications-push', 'uses' => 'NotificationViewController@getPushNotifications']);

    Route::get('notifications/gallery-upload', ['as' => 'stateadmin.notifications-gallery-upload', 'uses' => 'NotificationViewController@getPingToGalleryUploadView']);

    Route::get('notifications/gallery-library', ['as' => 'stateadmin.notifications-gallery-library', 'uses' => 'NotificationViewController@getPingToGalleryLibraryView']);

});