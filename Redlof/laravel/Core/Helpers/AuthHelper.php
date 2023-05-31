<?php
namespace Redlof\Core\Helpers;

use Exceptions\EntityNotFoundException;
use Exceptions\InvalidCredentialsException;
use Exceptions\UnAuthorizedException;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Token;

class AuthHelper {

	function __construct() {}

	public static function attempt($credentials) {
		$RetVal = false;

		// Get field name by helper function
		// make a hit in user table to authenticate
		// If authrized return true
		// Else return fasle
		$password = $credentials['password'];

		$email = strtolower($credentials['email']);

		$User = \DB::table('users')->where('email', $email)->first();

		if (!$User) {
			throw new EntityNotFoundException("Invalid Credentials. Please make sure that you have entered the correct username and password.");
		}

		if (!Hash::check($password, $User->password)) {
			throw new InvalidCredentialsException("Invalid Credentials. Please make sure that you have entered the correct username and password.");
		}

		$UserObj = \UserHelper::getUser($email, 'email');

		$Data = [];

		// Call method to Create Token
		$Data['token'] = self::createToken($UserObj);
		$Data['user'] = $UserObj;

		return $Data;
	}

	public static function createToken($UserObj, $Claims = null) {
		if (!$UserObj) {
			throw new EntityNotFoundException("Invalid Credentials. Please make sure that you have entered the correct username and password.");
		}

		$token = false;

		// try {
		$ttl = time() + 15552000; // 6 Months 60*60*24*180;

		$customClaims = [
			"exp" => $ttl,
			"role" => $UserObj->formatted->roles[0]->name,
			"email" => $UserObj->formatted->email,
			"iss" => config('redlof.name'),
		];

		$token = JWTAuth::fromUser($UserObj, $customClaims);

		// } catch (JWTException $e) {
		// 	// something went wrong
		// 	throw new TPLFailedException("Token Creation failed ".$e->getMessage());
		// }

		setcookie('redlof_token', $token, time() + (129600 * 30), "/");
		return $token;
	}

	public static function destoryToken($UserObj, $Claims = null) {

		$token = JWTAuth::getToken();

		try {
			JWTAuth::invalidate($token);
		} catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(['msg' => 'Token expired', 'status' => $e->getStatusCode()], $e->getStatusCode());
		}

		return $token;
	}

	public static function getCurrentUser($isUser = true) {

		$redlof_token = isset($_COOKIE['redlof_token']) ? $_COOKIE['redlof_token'] : null;

		if ($redlof_token == null) {
			$redlof_token = \Request::header('Authorization');
			$redlof_token = str_replace("Bearer ", "", $redlof_token);
		}

		try {

			if (!empty($redlof_token)) {
				$redlof_token = new Token($redlof_token);
				$user = JWTAuth::authenticate($redlof_token);
			} else {
				$user = JWTAuth::parseToken()->authenticate();
			}

			if (!$user) {
				throw new UnAuthorizedException;
			}
		} catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			throw new UnAuthorizedException;
		} catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			throw new UnAuthorizedException;
		} catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
			throw new UnAuthorizedException;
		}

		$current_user = \AppDataCache::get('current_user');

		if ($current_user != NULL) {
			return $current_user;
		}

		if ($isUser) {
			$user = \UserHelper::getUser($user->id);
		}

		\AppDataCache::set('current_user', $user);

		return $user;
	}

	public static function checkRoleAccess($roles) {

		if (JWTAuth::getToken() == FALSE) {
			throw new UnAuthorizedException("You are not authorized");
		}

		if (self::getCurrentUser()->hasRole($roles) == FALSE) {
			throw new UnAuthorizedException;
		}
	}

	public static function isUserSignedIn() {

		if (JWTAuth::getToken()) {
			return true;
		}

		return false;
	}

	public static function isSignedInWithCookie() {

		$redlof_token = isset($_COOKIE['redlof_token']) ? $_COOKIE['redlof_token'] : null;

		if ($redlof_token == null) {

			$redlof_token = \Request::header('Authorization');
			$redlof_token = str_replace("Bearer ", "", $redlof_token);
		}

		if ($redlof_token != null) {
			return true;
		}

		return false;
	}
}