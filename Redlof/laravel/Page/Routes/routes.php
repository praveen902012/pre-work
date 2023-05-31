<?php

Route::get('partial/include/{name}', ['uses' => 'PartialController@getInclude']);

Route::get('partial/{name}', ['uses' => 'PartialController@getPage']);
Route::get('popup/page/{name}', ['uses' => 'PartialController@getPopups']);

Route::group(array('prefix' => 'api'), function () {
	Route::post('contact/send', ['uses' => 'ContactController@submitContact']);

	Route::post('signin', ['uses' => 'AccessController@postSignIn']);
	Route::post('signup', ['uses' => 'AccessController@postSignUp']);

});

Route::group(array('prefix' => 'api'), function () {
	Route::post('password/email', ['uses' => 'PasswordController@postResetLink']);
	Route::post('password/reset', ['uses' => 'PasswordController@postResetPassword']);
	Route::post('password/phone', ['uses' => 'PasswordController@postResetPhone']);

	// SignOut API
	Route::get('auth/signout', ['uses' => 'PasswordController@postSignOut']);

	// State API

	Route::get('allstates', ['uses' => 'PageController@getStates']);
	//Route::get('get-user-thanks-stats', ['uses' => 'PageController@getUserThanksStats']);

	//Route::post('allow-access', ['uses' => 'PageController@postGrantAllowAccess']);

	// To bulk upload locality
	Route::post('upload/locality', ['uses' => 'PageController@addLocality']);

});

// DB DUMP ROUTE
//Route::get('data-migration', 'PageViewController@dbMigration');

Route::group(['middleware' => ['web']], function () {

	Route::get('/', ['as' => 'home.get', 'uses' => 'PageViewController@getHome']);
	Route::get('home', ['as' => 'home.get', 'uses' => 'PageViewController@getHome']);
	Route::get('about', ['as' => 'about.get', 'uses' => 'PageViewController@getAbout']);
	Route::get('contact', ['as' => 'contact.get', 'uses' => 'PageViewController@getContact']);
	Route::get('faqs', ['as' => 'faqs.get', 'uses' => 'PageViewController@getFaqs']);
	Route::get('privacy', ['as' => 'privacy.get', 'uses' => 'PageViewController@getPrivacy']);
	Route::get('terms', ['as' => 'terms.get', 'uses' => 'PageViewController@getTerms']);
	Route::get('help', ['as' => 'help.get', 'uses' => 'PageViewController@getHelp']);
	Route::get('team', ['as' => 'team.get', 'uses' => 'PageViewController@getTeam']);
	Route::get('feedback', ['as' => 'feedback.get', 'uses' => 'PageViewController@getFeedback']);
	Route::get('gallery', ['as' => 'gallery.get', 'uses' => 'PageViewController@getGallery']);
	Route::get('report', ['as' => 'report.get', 'uses' => 'PageViewController@getReport']);

	Route::get('gratitude', ['as' => 'all-campaign.get', 'uses' => 'PageViewController@getCampaign']);
//Route::get('check/allow-access', ['as' => 'allowaccess', 'uses' => 'PageController@getAllowAccess']);

	Route::get('signin', ['as' => 'signin.get', 'uses' => 'PageViewController@getSignIn']);
	Route::get('signup', ['as' => 'signup.get', 'uses' => 'PageViewController@getSignUp']);

	Route::get('resend-confirmation', ['as' => 'confirmationresend.get', 'uses' => 'PageViewController@getResendConfirmation']);
	Route::get('forgot-password', ['as' => 'forgotpassword.get', 'uses' => 'PageViewController@getForgotPassword']);

	Route::get('reset-password', ['as' => 'resetpassword.get', 'uses' => 'PageViewController@getResetPassword']);

	Route::get('change-password', ['as' => 'changepassword.get', 'uses' => 'PageViewController@getChangePassword']);

	Route::get('password/reset/{token}', ['as' => 'forgotpassword.rset.get', 'uses' => 'PageViewController@getResetpassword']);

// Auth Admin
	Route::get('admin-signin', ['as' => 'signin.admin.get', 'uses' => 'PageViewController@getAdminSignIn']);

	Route::get('member/{user_id}/{user_name}/timeline', ['as' => 'public.profile.timeline', 'uses' => 'PageViewController@getMemberPublicProfileView'])->where('user_id', '[0-9]+');

	Route::get('member/{user_id}/{user_name}/about', ['as' => 'public.profile.about', 'uses' => 'PageViewController@getMemberAboutProfileView'])->where('user_id', '[0-9]+');

	Route::get('post/public/{post_id}', ['as' => 'public.post', 'uses' => 'PageViewController@getSinglePostView'])->where('post_id', '[0-9]+');

	Route::get('{company}/confirmation', ['as' => 'company.confirmation', 'uses' => 'PageController@getCompanyConfirmationView']);

});