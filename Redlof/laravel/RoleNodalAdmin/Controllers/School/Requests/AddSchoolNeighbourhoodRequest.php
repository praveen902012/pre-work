<?php
namespace Redlof\RoleNodalAdmin\Controllers\School\Requests;

use Redlof\Core\Requests\Request;

class AddSchoolNeighbourhoodRequest extends Request {

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

			'range0' => 'bail|required|min:1',

		];
	}

	public function messages() {

		return [

			'range0.min' => 'Select atleast one region under the range 0f 1-3 kms',
			'range0.required' => 'Select atleast one region under the range 0f 1-3 kms',

		];
	}

}