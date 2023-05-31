<?php
namespace Classes;

class Message {

	public $title;
	public $message;
	public $summaryText;
	public $style;
	public $soundname;
	public $vibrationPattern;
	// TODO:: Define a type and take input as a picture

	public function __construct() {
		$this->title = '';
		$this->message = '';
		$this->summaryText = 'There are %n% notifications';
		$this->style = 'inbox';
		$this->soundname = 'default';
		$this->vibrationPattern = [1000, 10000, 500, 500];
	}

	public function prepareMessage($data = null) {

		$Data = array();
		$Data['data'] = array();

		$Data['data']['title'] = $this->title;
		$Data['data']['style'] = $this->style;
		$Data['data']['summaryText'] = $this->summaryText;
		$Data['data']['soundname'] = $this->soundname;

		if (is_array($data)) {
			// if data is not numll./.. its has be an array

			$KeyWords = array();
			$Values = array();

			foreach ($data as $key => $value) {
				array_push($KeyWords, $key);
				array_push($Values, $value);
			}

			$this->message = str_replace($KeyWords, $Values, $this->message);
		}

		$Data['data']['message'] = $this->message;

		$FinalData = array('GCM' => json_encode($Data));

		// TODO: Prepare the same object for APNS as well

		return $FinalData;
	}
}
