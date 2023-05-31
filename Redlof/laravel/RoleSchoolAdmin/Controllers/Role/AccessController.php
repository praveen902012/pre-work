<?php

namespace Redlof\RoleSchoolAdmin\Controllers\Role;

use Exceptions\EntityNotFoundException;
use Exceptions\InvalidCredentialsException;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Redlof\Auth\Classes\AuthHelper;
use Redlof\Core\Controllers\Controller;

class AccessController extends Controller
{
    public function __construct()
    {}

    public function postSignIn(Request $request)
    {

        $request->merge(['role_type' => 'role-school-admin']);

        $Data = array();

        $User = \DB::table('users')->where('phone', $request->phone)->first();

        if (!$User) {
            throw new EntityNotFoundException("We don't see a user with this credentials.");
        }

        $Role = \DB::table('role_user')->where('user_id', $User->id)->first();

        if (!$Role) {
            throw new EntityNotFoundException("We don't see a user with this credentials.");
        }

        $RoleId = $Role->role_id;

        $Data['role'] = \DB::table('roles')->find($RoleId);
        if (!$Data['role']) {
            throw new EntityNotFoundException("We don't see a user with this credentials.");
        }

        $Data['user'] = $User;

        if (!$Data) {
            throw new EntityNotFoundException("We don't see a user with this credentials.");
        }

        if ($Data['role']->name != $request['role_type']) {

            throw new EntityNotFoundException("We don't see a user with this credentials.");
        }

        $User = \DB::table('users')->where('phone', $request->phone)->first();

        if (!$User) {
            throw new EntityNotFoundException("We don't see a user with this credentials.");
        }

        if (!Hash::check($request->password, $User->password)) {
            throw new InvalidCredentialsException("Invalid Credentials. Please make sure that you have entered the correct password.");
        }

        $userObj = \Models\User::where('phone', $request->phone)->with(['roleuser.role'])->first();

        if (!$userObj) {
            throw new EntityNotFoundException("No user found matching the criteria");
        }

        $user = \UserHelper::process($userObj);

        // Call method to Create Token
        $Data['token'] = \AuthHelper::createToken($user);
        $Data['user'] = $user;

        $showObject = [
            'redirect_state' => route('schooladmin.dashboard'),
        ];

        // Return the token as response
        return response()->json(['token' => $Data['token'], 'msg' => 'Successfully Signed In', 'show' => $showObject], 200);
    }

    public function postSignOut()
    {

        \UserHelper::checkAuthorized($request->all());
        $token = \AuthHelper::destoryToken();

        return response()->json(['msg' => 'Successfully Signed Out'], 200);
    }
}
