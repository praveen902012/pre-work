<?php
namespace Redlof\Engine\SystemCommunication;

class PingToPopup {

	public function init($user_id) {

		$content = NULL;
		$notifications = \Models\SystemCommunication::where('type', 'popup')
			->where('user_id', $user_id)
			->where('trigger_time', '<=', \Carbon::now())
			->where('expiry_time', '>=', \Carbon::now())
			->orderBy('created_at', 'asc')
			->get();

		if (count($notifications) > 0) {
			$content = $notifications[0]->content;
			$notifications[0]->forceDelete();
		}

		return $content;
	}

}