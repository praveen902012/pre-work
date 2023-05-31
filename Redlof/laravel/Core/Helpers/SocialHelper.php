<?php
namespace Redlof\Core\Helpers;

use Models\User;
use Models\UserProvider;

/**
 * API Helper class
 */
class SocialHelper {

	public function __construct() {
	}

	public static function saveRemoteUserPhoto($Link, $User) {

		$filename = null;

		$Ext = pathinfo($Link, PATHINFO_EXTENSION);

		$ImgObj = \Image::make($Link);

		$filename = strtotime($User->created_at) . '_' . $User->id . '.jpg';

		$ImageNewObj = public_path() . '/temp/' . $filename;

		$ImgObj->save($ImageNewObj);

		$PublicLink = asset('temp/' . $filename);

		\AWSHelper::pushToS3WithBody($filename, $PublicLink, 'userphotos');
		\AWSHelper::pushToS3WithBody($filename, $PublicLink, 'userphotos/thumb');

		// Clear the temp dir
		\AppHelper::cleanTempDir();

		return $filename;
	}

	public static function checkLinkedUser($ProviderData, $provider) {

		if ($provider == 'facebook') {
			$providerId = $ProviderData['id'];
		} else {
			$providerId = $ProviderData['sub'];
		}

		$userprovider = UserProvider::where('provider_id', $providerId)->where('provider', $provider)->first();

		if ($userprovider) {
			$user = User::find($userprovider->user_id);

			if ($user) {
				return true;
			}

			return false;
		}

		return false;
	}

	public static function checkExistenseofEmailForSocial($EmailId, $provider) {

		$RetVal = array();

		$RetVal['user'] = User::where('email', $EmailId)->first();

		if (!$RetVal['user']) {
			$RetVal['has'] = false;
			return $RetVal;
		}

		$userProvider = UserProvider::where('user_id', $RetVal['user']->id)->where('provider', $provider)->first();

		if ($userProvider) {
			$RetVal['has'] = 'provider';
			return $RetVal;
		}

		return $RetVal;
	}

	public static function checkExistenseofEmailForTwitter($ProviderData) {

		$RetVal = array();

		$RetVal['user'] = User::where('email', $ProviderData->screen_name . '_tw@rte.com')->where('username', $ProviderData->screen_name)->first();

		if (!$RetVal['user']) {
			$RetVal['has'] = false;
			return $RetVal;
		}

		$userProvider = UserProvider::where('user_id', $RetVal['user']->id)->where('provider', 'twitter')->first();

		if ($userProvider) {
			$RetVal['has'] = 'provider';
			return $RetVal;
		}

		return $RetVal;
	}

	public static function processCampaignMessages($messages) {

		foreach ($messages as $message) {

			$message->time_ago = \DateHelper::displayAgoEquivalentOfDate($message->created_at);

		}

		return $messages;

	}
}