<?php
namespace Helpers;

class PingtoHelper {

	public static function triggerNotification($user, $data, $type) {

		if(isset($data['student_content'])){

			$data['content'] = $data['student_content'];
		}

		if(isset($user->mobile)){

			$user->phone = $user->mobile;
		}

		if ($type == 'mail') {

			$content = [
				'content' => $data['content'],
				'template' => null,
				'subject' => $data['subject'],
				'to_email' => $user->email,
			];

		} elseif ($type == 'sms') {

			$content = [
				'content' => $data['content'],
				'to' => $user->phone,
			];

		}

		$sendTime = \Carbon::now();

		$expiryTime = \Carbon::now()->addYear();

		\Models\SystemCommunication::create([
			'user_id' => $user->id,
			'email' => $user->email,
			'type' => $type,
			'content' => $content,
			'trigger_time' => $sendTime,
			'expiry_time' => $expiryTime,
		]);

		return true;
	}

}