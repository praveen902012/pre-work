<?php
namespace Redlof\State\Controllers\Registration\Requests;

use Redlof\Core\Requests\Request;

class VerifyOTPRequest extends Request {

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
			'otp' => 'bail|required|numeric|digits:4',
		];
	}

	public function messages() {

		return [
			'otp.required' => 'Please enter one time password',
			'otp.numeric' => 'This otp is not valid',
			'otp.digits' => 'This otp is not valid',
		];
	}

}