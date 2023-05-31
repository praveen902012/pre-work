<?php
namespace Redlof\Page\Controllers\Requests;

use Redlof\Core\Requests\Request;

class PhonePasswordRequest extends Request {

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
			'phone' => 'required',
		];
	}
	public function messages() {
		return [
			'phone.required' => 'Please enter your phone number.<br>',
		];
	}
}
