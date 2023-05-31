<?php
namespace Redlof\State\Controllers\Registration\Requests;

use Redlof\Core\Requests\Request;

class ResumeRegistrationRequest extends Request {

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
			'registration_id' => 'bail|required|numeric|digits:10|exists:registration_basic_details,registration_no',
		];
	}

	public function messages() {

		return [
			'registration_id.required' => 'Please enter your registration id',
			'registration_id.exists' => 'This registration number does not exist in the platform',
			'registration_id.numeric' => 'This registration is not valid',
			'registration_id.digits' => 'This registration is not valid',
		];
	}

}