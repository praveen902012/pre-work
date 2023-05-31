<?php
namespace Redlof\Engine\SystemCommunication;

class PingToBrowser {

	#there will a function here
	#its purpose is to get records
	#from the systems_communications table
	#where type is browser_push
	#and trigger time has passed
	#and expiry time has not passed
	#then get all the users to whom
	#we need to trigger notification to
	#foreach record trigger browser notification
	public function init() {
		$records = \Models\SystemCommunication::where('type', 'browser_push')
			->whereDate('trigger_time', '<=', \Carbon::now())
			->whereDate('expiry_time', '>', \Carbon::now())
			->get();

		if (count($records) > 0) {

			foreach ($records as $key1 => $record) {

				$user = \Models\User::select('id', 'first_name', 'last_name')
					->with(['subscriptions'])
					->where('id', $record->user_id)
					->first();

				if (!empty($user->subscriptions) && count($user->subscriptions) > 0) {

					foreach ($user->subscriptions as $key2 => $subscription) {

						$subscription->body = $record->content;

						if (gettype($record->content) == 'object') {

							if (isset($record->content->body)) {
								$subscription->body = $record->content->body;
							}

						}

						$user->notify(new \Events\BrowserNotification($subscription));

					}
				}

				$record->forceDelete();

			}

		}

	}
}