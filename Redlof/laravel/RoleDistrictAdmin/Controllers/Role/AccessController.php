<?php
namespace Redlof\RoleDistrictAdmin\Controllers\Role;

use Exceptions\ValidationFailedException;
use Illuminate\Http\Response;
use Redlof\Auth\Classes\AuthHelper;
use Redlof\Core\Controllers\Controller;
use Redlof\RoleDistrictAdmin\Controllers\Role\Requests\SignInRequest;

class AccessController extends Controller {
	public function __construct() {

	}

	public function postSignIn(SignInRequest $request) {

		$request->merge(['role_type' => 'role-district-admin']);

		\UserHelper::checkAuthorized($request->all());

		// Call Authengine::attempt
		// If you are getting a return value, you have got the token
		$Data = \AuthHelper::attempt($request->only('email', 'password'));

		$UserObject = $Data['user'];

		$Role = \RoleHelper::getRolebyUserId($UserObject->id);

		$check = \Models\StateDistrictAdmin::where('user_id', $UserObject->id)->where('status', 'inactive')->get();

		if (count($check) > 0) {
			throw new ValidationFailedException("Your login access can been blocked");
		}

		$redirect_state = route('districtadmin.dashboard');

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
