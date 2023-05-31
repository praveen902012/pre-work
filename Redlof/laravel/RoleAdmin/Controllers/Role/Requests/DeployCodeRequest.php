<?php
namespace Redlof\RoleAdmin\Controllers\Role\Requests;

use Redlof\Core\Requests\Request;

class DeployCodeRequest extends Request {

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
			'username' => 'required',

			'password' => 'required',

			'server' => 'required',
		];
	}

	public function messages() {
		return [
			'username.required' => 'username is required field.<br>',

			'password.required' => 'password is required field.<br>',
			
			'server.required' => 'server is required field.<br>',
		];
	}
}
