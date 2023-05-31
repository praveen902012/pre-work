<?php
namespace Redlof\Engine\SystemCommunication;

use Redlof\Core\Helpers\MsgHelper;

class PingToSms {

	public function init() {
		$notifications = \Models\SystemCommunication::where('type', 'sms')
			->whereDate('trigger_time', '<=', \Carbon::now())
			->whereDate('expiry_time', '>', \Carbon::now())
			->get();

		foreach ($notifications as $key => $notification) {

			$data['message'] = $notification->content->content;
			$data['phone'] = $notification->content->to;

			MsgHelper::sendSyncSMS($data);

			$notification->forceDelete();
		}
	}

}