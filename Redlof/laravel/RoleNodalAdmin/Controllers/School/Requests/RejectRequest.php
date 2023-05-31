<?php
namespace Redlof\RoleNodalAdmin\Controllers\School\Requests;

use Redlof\Core\Requests\Request;

class RejectRequest extends Request {

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
			'reject_reason' => 'bail|required|min:3|max:500',

		];
	}

	public function messages() {

		return [

			'reject_reason.required' => 'Please add the reason',
			'reject_reason.min' => 'Reason may contain atleast 4 characters',
			'reject_reason.max' => 'Reason may not contain more than 500 characters',

		];
	}

}