<?php
namespace Redlof\RoleSchoolAdmin\Controllers\Student\Requests;

use Redlof\Core\Requests\Request;

class UpdateStudentBankDetailsRequest extends Request {

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
			'account_number' => 'required|min:6|max:20|regex:/^([0-9]+)$/|confirmed',
			'account_holder_name' => 'required|min:2|regex:/^([a-zA-Z ]+)$/|max:50',

			'ifsc_code' => 'required|alpha_num|min:11|max:11',
		];
	}

	public function messages() {

		return [

		];
	}

}