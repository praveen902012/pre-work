<?php
namespace Redlof\RoleAdmin\Controllers\Role\Requests;

use Redlof\Core\Requests\Request;

class SignInRequest extends Request {

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
			'email' => 'required',

			'password' => 'required',
		];
	}
}
