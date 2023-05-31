<?php
namespace Redlof\Engine\SystemCommunication;

class PingToWeb {

	public function init() {
		$notifications = \SystemCommunication::where('type', 'web')
			->whereDate('trigger_time', '<=', \Carbon::now())
			->whereDate('expiry_time', '>', \Carbon::now())
			->get()
			->trimTimeStamp();

		foreach ($notifications as $key => $notification) {

			$member = null;
			if (isset($record->content['member']) && !empty($record->content['member'])) {
				$member = $record->content['member'];
			}

			$newAction = null;
			if (isset($record->content['newAction']) && !empty($record->content['newAction'])) {
				$newAction = $record->content['newAction'];
			}

			\NotificationHelperClass::trigger($record->content['action'], $record->content['resource'], $member, $newAction);
		}
	}

}