<?php
namespace Redlof\RoleSchoolAdmin\Controllers\Student\Requests;

use Redlof\Core\Requests\Request;

class AddStudentBankDetailsRequest extends Request {

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
			'account_number' => 'min:6|max:20|regex:/^([0-9]+)$/|confirmed',
			'account_holder_name' => 'min:2|regex:/^([a-zA-Z ]+)$/|max:50',

			'ifsc_code' => 'alpha_num|min:11|max:11',
		];
	}

	public function messages() {

		return [

		];
	}

}