<?php
namespace Redlof\RoleNodalAdmin\Controllers\Role\Requests;

use Redlof\Core\Requests\Request;

class UdiseRequest extends Request {

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
			'udise' => 'bail|required|unique:schools|numeric|digits:11',
		];
	}
}
