<?php
namespace Redlof\Engine\SystemCommunication;

class PingToMail {

	//When init function from this class is triggered
	//It should go to the system communication table
	//check all the rows with the type 'email'
	//get the email id and content
	//content will have all the details to be sent
	//then we can send the mail
	//but
	//before that we need to take care of few things
	//also after that
	//so before sending an email
	//check if the current time is more than the trigger time
	//and and current time is not more than expiry time
	//that means current time should be between trigger and expiry time
	//if that is true send the mail
	//and then delete the row
	//bye bye

	public function init() {
		$notifications = \Models\SystemCommunication::where('type', 'mail')
			->whereDate('trigger_time', '<=', \Carbon::now())
			->whereDate('expiry_time', '>', \Carbon::now())
			->get();

		foreach ($notifications as $key => $notification) {

			$EmailData['template_content'] = $notification->content->content;
			$EmailData['email'] = $notification->content->to_email;

			\MailHelper::sendSyncMail('districtadmin::emails.system_notification_email', $notification->content->subject, $notification->content->to_email, $EmailData);

			$notification->forceDelete();
		}
	}

}