<?php
namespace Classes;

use Aws\Sns\Exception\SnsException;
use Aws\Sns\SnsClient;
use Config;
use Models\Device;
use Exceptions\ActionFailedException;

/**
 * Notification Class
 */
class NotificationClass {

	function __construct() {
		# code...
	}

	public function notify($user_ids, $messageObj, $data = null) {

		if (!is_array($user_ids)) {
			$users[0] = $user_ids;
		} else {
			$users = $user_ids;
		}

		foreach ($users as $user) {
			// Get ARNs for all the users ids
			$ARNs = $this->getUserARNs($user);

			// Prepare the message
			$Message = $messageObj->prepareMessage($data);

			// Call the notify method to send the push notification to user
			$this->push($ARNs, $Message);
		}
	}

	public function queueNotify($user_ids, $messageObj, $data = null) {
		dispatch(new \App\Redlof\Core\Jobs\SendPushNotification($user_ids, $messageObj, $data));
	}

	private function push($ARNs, $Message) {

		$snsClient = SnsClient::factory(array(
			'region' => Config::get('aws.region'),
			'version' => Config::get('aws.version'),
		));

		// Loop through the user to be notified
		foreach ($ARNs as $Endpoint) {

			try {
				// Notify to users
				$snsClient->publish(array(
					'Message' => json_encode($Message),
					'MessageStructure' => 'json',
					'TargetArn' => $Endpoint,
				));

			} catch (SnsException $e) {
				\Log::info("We are not able to send notification to the user because the end point has been disabled.");
				continue;
				// TODO: Need to handle in proper way
				//throw new ActionFailedException("We are not able to send notification.");
			}
		}
	}

	private function getUserARNs($user_id) {
		// Get the all user arn data by user ids
		$Arns = Device::where('user_id', $user_id)->get()->pluck('endpoint_arn');

		if (!$Arns) {
			return false;
		}

		return $Arns;
	}

	public function registerEndPointARN($Data) {

		$snsClient = SnsClient::factory(array(
			'region' => Config::get('aws.region'),
			'version' => Config::get('aws.version'),
		));

		try {

			$EndPointARN = $snsClient->createPlatformEndpoint(array(
				'PlatformApplicationArn' => Config::get('redlof.AWS_SNS_END_POINT'),
				'Token' => $Data->registration_id,
				'CustomUserData' => $Data->user_id,
			));

		} catch (SnsException $e) {
			// $resp = $e->getResponse();
			// $parser = new \Aws\Api\ErrorParser\XmlErrorParser();
			// $msg = $parser($resp);
			// dd($msg['message']);
			// \Log::info("We are not able to register end point arn, because of bad requet input");
			// TODO: Need to handle in proper way
			throw new ActionFailedException("We are not able to register end point arn, because of bad request input");
		}

		return $EndPointARN;
	}

	public function updateEndPointARN($Data) {

		$snsClient = SnsClient::factory(array(
			'region' => Config::get('aws.region'),
			'version' => Config::get('aws.version'),
		));

		try {

			$EndPointARN = $snsClient->setEndpointAttributes(array(
				'EndpointArn' => $Data->endpoint_arn,
				'Attributes' => array(
					'Enabled' => true,
					'Token' => $Data->registration_id,
				),
			));

		} catch (SnsException $e) {
			\Log::info("We are not able to update the token for endpoint");
			// TODO: Need to handle in proper way
			//throw new ActionFailedException("We are not able to update the token for endpoint");
		}

		return $EndPointARN;
	}

}