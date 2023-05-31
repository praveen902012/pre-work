<?php
namespace Redlof\Core\Helpers;

class MailHelper {
	public static function dispatchBulkMail($Data) {
		// Get message, email ids, subject from input parameter
		$mailBody = array(
			'emailmessage' => $Data['message'],
		);

		$mailsubject = $Data['subject'];

		$EmailIds = $Data['EmailIds'];

		foreach ($EmailIds as $Email) {
			self::sendMailToUsers($mailBody, $Email, $mailsubject);
		}

		return true;

	}

	public static function sendMailToUsers($datamsg, $EmailId, $mailsubject) {

		\Mail::send('admin::emails.sendmessagetousers', $datamsg, function ($message) use ($datamsg, $EmailId, $mailsubject) {
			$message->bcc($EmailId);
			$message->subject($mailsubject);
		});
	}

	public static function sendSyncMail($viewname, $subject, $EmailId, $datamsg) {
		\Mail::send($viewname, $datamsg, function ($message) use ($datamsg, $EmailId, $subject) {
			$message->to($EmailId);
			$message->subject($subject);
		});
	}

	public static function sendMail($viewname, $subject, $EmailId, $datamsg) {
		dispatch(new \Redlof\Core\Jobs\SendMail($viewname, $subject, $EmailId, $datamsg));
	}
}
