<?php
namespace Redlof\RoleNodalAdmin\Controllers\State\Requests;

use Redlof\Core\Requests\Request;

class AddDistrictRequest extends Request {

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
			'state_id' => 'bail|required|unique:state_admins,state_id',

			'first_name' => 'bail|required|alpha',

			'last_name' => 'bail|required|alpha',

			'email' => 'bail|required|email',
		];
	}

	public function messages() {
		return [
			'state_id.required' => 'Please add the State ID',

			'state_id.unique' => 'It seems State ID has been registered already',

			'first_name.required' => 'First name is required',

			'first_name.alpha' => 'First name may contain alphabet only',

			'last_name.alpha' => 'Last name may contain alphabet only',

			'last_name.required' => 'Last name is required',

			'email.required' => 'Email is required',

			'email.email' => 'Provide a valid Email',
		];
	}

}