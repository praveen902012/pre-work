<?php
namespace Redlof\RoleSchoolAdmin\Controllers\Student\Requests;

use Redlof\Core\Requests\Request;

class DropoutReasonRequest extends Request {

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
			'reason' => 'bail|required|min:3|max:500',
		];
	}

	public function messages() {
		return [

			'reason.required' => 'Reason is required',
			'reason.min' => 'Reason may not contain less than 3 characters',
			'reason.max' => 'Reason may not contain more than 500 characters',

		];
	}

}