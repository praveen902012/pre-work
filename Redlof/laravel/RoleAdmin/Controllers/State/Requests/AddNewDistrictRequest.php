<?php
namespace Redlof\RoleAdmin\Controllers\State\Requests;

use Redlof\Core\Requests\Request;

class AddNewDistrictRequest extends Request {

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

			'name' => 'bail|required|regex:/^([a-zA-Z ]+)$/|min:4|max:60',
			'state_slug' => 'bail|required',
			'state_id' => 'bail|required',
		];
	}

	public function messages() {
		return [

		];
	}

}