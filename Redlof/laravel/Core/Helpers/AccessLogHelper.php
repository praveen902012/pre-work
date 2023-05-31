<?php
namespace Redlof\Core\Helpers;

use Models\AccessList;
use Models\AccessLog;
use Models\OnlineUser;

/**
 * AccessLog Helper class
 */
class AccessLogHelper {

	function __construct() {
	}

	public function record($member, $accessed_entity) {

		$accesslog = new AccessLog();

		$accesslog->user_id = $member->id;
		$AccessList = AccessList::where('name', $accessed_entity)->select('id')->first();

		if ($AccessList) {
			$accesslog->access_id = $AccessList->id;
			$accesslog->save();
		}
	}

	public function recordOnlineUserStatus($userId) {
		$expiration_time = \Carbon::now()->addMinutes(3);
		$userOnlineObj = OnlineUser::updateOrCreate(['user_id' => $userId],
			['expiring_at' => $expiration_time,
				'online' => true]);
		return $userOnlineObj;
	}

}