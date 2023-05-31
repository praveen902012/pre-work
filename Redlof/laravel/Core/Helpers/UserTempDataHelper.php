<?php
namespace Redlof\Core\Helpers;

class UserTempDataHelper {
	protected $ConfigData = array();
	protected $UserId = null;

	public function set($key, $value, $user_id = null) {
		// Fill the key value to the Config Data Array
		$this->ConfigData[$key] = $value;
		$this->UserId = $user_id;

		// Call the save method to save the configuration to the db
		$this->save();
	}

	public function get($key, $user_id = null) {
		// check if key is empty return false
		if (empty($key)) {
			return false;
		}

		// DB Row Query to get the user configuration
		$Data = \DB::table('user_temp_data')->where('user_id', $user_id)->first();

		if (!$Data) {
			return false;
		}

		$Data = (array) json_decode($Data->data);

		// get the value of key
		if (isset($Data[$key])) {
			// return the value
			return $Data[$key];
		}

		return false;
	}

	private function save() {
		$Date = new \DateTime;

		// DB Row Query to save the user configuration
		$UserConfigObj = \DB::table('user_temp_data')->where('user_id', $this->UserId)->first();

		if ($UserConfigObj) {
			\DB::table('user_temp_data')
				->where('user_id', $this->UserId)
				->update(array(
					'user_id' => $this->UserId,
					'data' => json_encode($this->ConfigData),
					'updated_at' => $Date,
				));

			return true;
		}

		\DB::table('user_temp_data')->insert(
			array(
				'user_id' => $this->UserId,
				'data' => json_encode($this->ConfigData),
				'created_at' => $Date,
				'updated_at' => $Date,
			)
		);

		return true;
	}
}