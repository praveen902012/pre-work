<?php
namespace Redlof\Core\Helpers;

use Exceptions\EntityNotFoundException;
use Models\User;

/**
 * User Helper class
 */
class UserHelper {

	function __construct() {
	}

	public static function getUser($value, $col_name = 'id', $operator = '=') {

		$userObj = User::where($col_name, $operator, $value)->with(['roleuser.role'])->first();

		if (!$userObj) {
			throw new EntityNotFoundException("No user found matching the criteria");
		}

		$user = self::process($userObj);

		return $user;
	}

	public static function process($users) {

		if (empty($users)) {
			return $users;
		}

		if (count($users) == 1) {
			$UsersArray = array();
			array_push($UsersArray, $users);
		} else {
			$UsersArray = $users;
		}

		foreach ($UsersArray as $key => $user) {

			$user->phone = (int) $user->phone;

			$fmt['id'] = $user->id;
			$fmt['name'] = $user->first_name . ' ' . $user->last_name;
			$fmt['email'] = $user->email;
			$fmt['dob'] = \DateHelper::formatDate($user->dob);

			$fmt['locale'] = $user->locale;
			$fmt['timezone'] = $user->timezone;

			$fmt['gender'] = ($user->gender == 'male') ? 'Male' : 'Female';

			$fmt['phone'] = (int) $user->phone;
			$fmt['joined'] = \DateHelper::formatDate($user->created_at);
			$fmt['updated'] = \DateHelper::formatDate($user->updated_at);
			$fmt['confirmed'] = $user->confirmed == 1 ? 'true' : 'false';
			$fmt['orig_photo_name'] = $user->photo;

			if ($user->photo != NULL) {
				$fmt['photo'] = \AWSHelper::getSignedUrl('userphotos/' . $user->photo);
				$fmt['photo_thumb'] = \AWSHelper::getSignedUrl('userphotos/thumb/' . $user->photo);
			} else {
				$fmt['photo'] = config('redlof.aws_s3_public_url') . config('redlof.aws_s3_bucket') . '/userphotos/default.jpg';
				$fmt['photo_thumb'] = config('redlof.aws_s3_public_url') . config('redlof.aws_s3_bucket') . '/userphotos/thumb/default.jpg';
			}

			$fmt['public_link'] = url('profile/' . str_slug($fmt['name']) . '/' . $user->global_id);

			$fmt['roles'] = array();

			foreach ($user['roleuser'] as $role) {
				$userrole = array();

				$userrole['id'] = $role->role->id;
				$userrole['name'] = $role->role->name;
				$userrole['display_name'] = $role->role->display_name;

				array_push($fmt['roles'], $userrole);
			}

			$user->formatted = json_decode(json_encode($fmt), FALSE);

			// Unset unwanted elements
			unset($user->roleuser);
		}

		return $users;
	}

	public static function resetUserPassword($User) {
		$user = User::find($User['id']);
		$user->password = $User['password'];
		$user->update();

		$EmailData = array(
			'first_name' => $user->first_name,
			'email' => $user->email,
			'password' => $User['password'],
		);

		$subject = 'Your Password Has Been Changed!';
		\MailHelper::sendSyncMail('admin::emails.sendpasswordresend', $subject, $user->email, $EmailData);
		return $user;
	}

	public static function ResendConfirmationMail($User) {
		$user = User::find($User['id']);

		$EmailData = array(
			'first_name' => $user->first_name,
			'email' => $user->email,
			'confirmation_code' => $user->confirmation_code,
		);

		$subject = 'Welcome to RTE!';
		\MailHelper::sendSyncMail('member::emails.welcome', $subject, $user->email, $EmailData);
		return $user;
	}

	public static function checkAuthorized($Cred) {

		$cred_email = strtolower($Cred['email']);
		$Data = \RoleHelper::getRolebyUserEmail($cred_email);

		if (!$Data) {
			throw new EntityNotFoundException("Invalid Credentials. Please make sure that you have entered the correct username and password.");
		}

		if ($Data['role']->name != $Cred['role_type']) {
			throw new EntityNotFoundException("UnAuthorized");
		} // elseif ($Data['user']->status == 'inactive' || $Data['user']->confirmed == FALSE) {
		//	throw new EntityNotFoundException("Please activate your account.");
		//}

		return true;
	}

	public static function getUserPhoto($id) {

		$User = \DB::table('users')->find($id);

		if ($User->photo == '' || $User->photo == NULL || strlen($User->photo) < 10) {
			$FileName = strtotime($User->created_at) . '_' . $User->id . '.png';
			// \Helper::generateUserDefaultPhoto($User, $FileName);
			// \UserHelper::updateFirstTimeUserPhoto($User->id, $FileName);
		} else {
			$CheckFileinS3 = \AWSHelper::checkS3Object($User->photo, 'userphotos');

			if (!$CheckFileinS3) {
				// \Helper::generateUserDefaultPhoto($User, $User->photo);
				// \UserHelper::updateFirstTimeUserPhoto($User->id, $User->photo);
			}

			$FileName = $User->photo;
		}

		$image = \AWSHelper::getFromS3($FileName, 'userphotos');
		$image = $image . '?decache=' . rand();
		return $image;
	}

	public static function updateFirstTimeUserPhoto($Id, $File) {
		return \DB::table('users')
			->where('id', $Id)
			->update(['photo' => $File]);
	}

	public static function setConifg($key, $value, $user_id = null) {

		// Fill the key value to the Config Data Array
		$Config = array();
		$Config[$key] = $value;

		// Saving The Data
		$Date = new \DateTime;

		// DB Row Query to save the user configuration
		$UserConfigObj = \DB::table('user_config')->where('user_id', $this->UserId)->first();

		if ($UserConfigObj) {
			\DB::table('user_config')
				->where('user_id', $user_id)
				->update(array(
					'user_id' => $user_id,
					'data' => json_encode($Config),
					'updated_at' => $Date,
				));

			return true;
		}

		\DB::table('user_config')->insert(
			array(
				'user_id' => $user_id,
				'data' => json_encode($Config),
				'created_at' => $Date,
				'updated_at' => $Date,
			)
		);
	}

	public static function getConfig($key, $user_id = null) {
		// check if key is empty return false
		if (empty($key)) {
			return false;
		}

		if ($user_id == null) {
			$user_id = auth()->user()->id;
		}

		// DB Row Query to get the user configuration
		$Data = \DB::table('user_config')->where('user_id', $user_id)->first();

		if (!$Data) {
			return false;
		}

		$Data = (array) json_decode($Data->data);

		// get the value of key
		if (isset($Data[$key])) {
			// return the value
			return $Data[$key];
		}

		return false;
	}

	public static function getAllUsersBasedOnSelection($UserIds) {
		$UsersEmailIds = User::whereIn('id', $UserIds)->lists('email');
		return $UsersEmailIds;

	}

	public static function checkExistenseofEmail($EmailId) {
		return User::where('email', $EmailId)->first();
	}

	public static function printGender($genderValue) {
		$genderDisplayName = $genderValue == 'm' ? 'male' : 'female';

		return $genderDisplayName;

	}

}