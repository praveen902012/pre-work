<?php
namespace Redlof\Engine\SystemCommunication;

class PingTo {

	private static $instance = null;

	private static $user;

	private static $data = [];

	public static function init(\Models\User $user) {

		if (self::$instance == null) {
			self::$instance = new PingTo();
		}

		self::$user = $user;

		return self::$instance;
	}

	public static function mail($content, $template, $subject, $to_email = NULL) {

		$content = [
			'content' => $content,
			'template' => $template,
			'subject' => $subject,
			'to_email' => ($to_email == NULL) ? self::$user->email : $to_email,
		];

		self::collect('email', $content);

		return self::$instance;
	}

	public static function mobile($content, $logo) {

		$content = [
			'content' => $content,
			'logo' => $logo,
		];

		self::collect('mobile_push', $content);

		return self::$instance;
	}

	public static function sms($content, $to) {

		$content = [
			'content' => $content,
			'to' => $to,
		];

		self::collect('sms', $content);

		return self::$instance;
	}

	public static function browser($content, $logo = NULL) {

		$endpoint = '';
		$auth_key = '';
		$public_key = '';

		$content = $content;

		self::collect('browser_push', $content);

		return self::$instance;
	}

	public static function web($content, $image) {

		$content = [
			'content' => $content,
			'image' => $image,
		];

		self::collect('web', $content);

		return self::$instance;
	}

	public static function popup($content) {

		$content = [
			'content' => $content,
		];

		self::collect('popup', $content);

		return self::$instance;
	}

	public static function trigger($sendTime = 'now', $expiryTime = 'never') {

		if ($sendTime == 'now') {
			$sendTime = \Carbon::now();
		}

		if ($expiryTime == 'never') {
			$expiryTime = \Carbon::now()->addYear();
		}

		if (is_array(self::$data)) {
			foreach (self::$data as $entry) {
				self::saveToDB($entry, $sendTime, $expiryTime);
			}
		}

		// Clean Up
		self::$data = NULL;
		self::$user = NULL;
	}

	private static function collect($type, $content) {

		$entry = [
			'type' => $type,
			'content' => $content,
		];

		if (is_array(self::$data)) {
			array_push(self::$data, $entry);
		}
	}

	private static function saveToDB($entry, $sendTime, $expiryTime) {

		\Models\SystemCommunication::create([
			'user_id' => self::$user->id,
			'email' => self::$user->email,
			'type' => $entry['type'],
			'content' => $entry['content'],
			'trigger_time' => $sendTime,
			'expiry_time' => $expiryTime,
		]);
	}

	public static function cron() {
		// This method would run through cron

		// Browser

		// Email
		// $MailObj = new PingToMail();
		// $MailObj->init();

		$SMSObj = new PingToSms();
		$SMSObj->init();

		// $SMSObj = new PingToBrowser();
		// $SMSObj->init();
	}

}