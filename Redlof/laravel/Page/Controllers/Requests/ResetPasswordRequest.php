<?php
namespace Redlof\Page\Controllers\Requests;

use Redlof\Core\Requests\Request;

class ResetPasswordRequest extends Request {

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
			'password' => 'required',
			'password_confirmation' => 'required|same:password',
		];
	}
	public function messages() {
		return [
			'password.required' => 'Please enter your password.<br>',
			'password_confirmation.required' => 'Please enter your password.<br>',
			'password_confirmation.same' => 'Your passwords do not match.<br>',
		];
	}
}
