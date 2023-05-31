<?php
namespace Redlof\Page\Controllers;

use Illuminate\Http\Response;
use Redlof\Auth\Classes\AuthHelper;
use Redlof\Core\Controllers\Controller;
use Redlof\Core\Helpers\ActivityHelper;
use Redlof\Page\Controllers\Requests\SignInRequest;

class AccessController extends Controller {
	public function __construct() {

	}

	public function postSignIn(SignInRequest $request) {

		$credentials = $request->all();
		$credentials['role_type'] = 'role-member';

		\UserHelper::checkAuthorized($credentials);

		// Call Authengine::attempt
		// If you are getting a return value, you have got the token
		$Data = \AuthHelper::attempt($request->only('email', 'password'));

		$UserObject = $Data['user'];

		$Role = \RoleHelper::getRolebyUserId($UserObject->id);

		if ($Role->name == 'role-admin') {

			$redirect_state = route('admin.dashboard');

		} else if ($Role->name == 'role-member') {

			$redirect_state = route('member.dashboard');
		}

		ActivityHelper::record($UserObject, 'signed-in');

		$showObject = [
			'redirect_state' => $redirect_state,
		];

		// Return the token as response
		return response()->json(['token' => $Data['token'], 'msg' => 'Successfully Signed In', 'show' => $showObject], 200);
	}

	public function postSignOut() {

		\UserHelper::checkAuthorized($request->all());
		$token = \AuthHelper::destoryToken();

		\AuthHelper::removeCookieToken();

		return response()->json(['msg' => 'Successfully Signed Out'], 200);
	}
}
