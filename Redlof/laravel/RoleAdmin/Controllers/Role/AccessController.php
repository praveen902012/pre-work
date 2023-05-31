<?php
namespace Redlof\RoleAdmin\Controllers\Role;

use Illuminate\Http\Response;
use Redlof\Auth\Classes\AuthHelper;
use Redlof\Core\Controllers\Controller;
use Redlof\RoleAdmin\Controllers\Role\Requests\SignInRequest;

class AccessController extends Controller {
	public function __construct() {

	}

	public function postSignIn(SignInRequest $request) {

		$request->merge(['role_type' => 'role-admin']);

		\UserHelper::checkAuthorized($request->all());

		// Call Authengine::attempt
		// If you are getting a return value, you have got the token
		$Data = \AuthHelper::attempt($request->only('email', 'password'));

		$UserObject = $Data['user'];

		$Role = \RoleHelper::getRolebyUserId($UserObject->id);

		if ($Role->name == 'role-admin') {

			$redirect_state = route('admin.dashboard');
		}

		$showObject = [
			'redirect_state' => $redirect_state,
		];

		// Return the token as response
		return response()->json(['token' => $Data['token'], 'msg' => 'Successfully Signed In', 'show' => $showObject], 200);
	}

	public function postSignOut() {

		\UserHelper::checkAuthorized($request->all());

		$token = \AuthHelper::destoryToken();

		return response()->json(['msg' => 'Successfully Signed Out'], 200);
	}
}
