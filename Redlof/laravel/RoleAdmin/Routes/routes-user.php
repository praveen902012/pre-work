<?php

Route::group(['middleware' => ['role:role-admin', 'throttle:45,60', 'web'], 'prefix' => 'api/admin', 'namespace' => 'Member'], function () {

	Route::get('members/all', ['uses' => 'MemberController@getAllMembers']);

	Route::get('member/search', ['uses' => 'MemberController@getMemberSearch']);

	Route::get('member/get/{id}', ['uses' => 'MemberController@getSingleMember'])->where('id', '[0-9]+');

	Route::get('member/profile/get/{id}', ['uses' => 'MemberController@getSingleMemberProfile'])->where('id', '[0-9]+');

});

Route::group(['middleware' => ['role:role-admin', 'web'], 'prefix' => 'admin', 'namespace' => 'Role'], function () {

	Route::get('members', ['as' => 'admin.members.get', 'uses' => 'RoleAdminViewController@getMembersView']);

	Route::get('member/{id}', ['as' => 'admin.member.get', 'uses' => 'RoleAdminViewController@getSingleMemberView']);

});