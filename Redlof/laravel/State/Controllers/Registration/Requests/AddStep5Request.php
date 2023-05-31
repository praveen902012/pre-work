<?php
namespace Redlof\State\Controllers\Registration\Requests;

use Redlof\Core\Requests\Request;

class AddStep5Request extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */

	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'registration_no' => 'bail|required|exists:registration_basic_details,registration_no',
			// 'preferences' => 'bail|required|min:1',
			// 'nearby_preferences' => 'bail|required',
			'accept' => 'required|accepted',

		];
	}

	public function messages() {

		return [
			'preferences.size' => 'Select 3 schools of your preference',
		];
	}

}