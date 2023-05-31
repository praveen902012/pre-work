<?php
namespace Redlof\Page\Controllers\Requests;

use Redlof\Core\Requests\Request;

class PasswordRequest extends Request {

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
			'email' => 'required|email',
		];
	}
	public function messages() {
		return [
			'email.required' => 'Please enter your email.<br>',
			'email.email' => 'Please enter valid email.<br>',
		];
	}
}
