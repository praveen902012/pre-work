<?php
namespace Redlof\Page\Controllers\Requests;

use Redlof\Core\Requests\Request;

class AddContactRequest extends Request {

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
			'name' => 'required',
			'email' => 'required|email',
			'message' => 'required|min:10|max:150',
			'phone' => 'required|regex:/^[789]\d{9}$/',
		];
	}
}
