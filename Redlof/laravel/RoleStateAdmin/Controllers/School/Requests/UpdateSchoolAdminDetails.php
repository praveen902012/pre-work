<?php
namespace Redlof\RoleStateAdmin\Controllers\School\Requests;

use Redlof\Core\Requests\Request;

class UpdateSchoolAdminDetails extends Request {

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
			// 'username' => 'bail|required|min:4|max:50',
			// 'email' => 'bail|required|regex:/^.+@.+$/i',
			'phone' => 'bail|required|numeric',
		];
	}

	public function messages() {

		return [

            'username.required' => 'Please Enter User Name',
            'username.min' => 'User Name Should contain atleast 3 character',
            'username.max' => 'User Name Should not contain more than 50 character',
            
            'email.required' => 'Please Enter Email-ID',
            'email.regex' => 'Please Enter Valid Email-ID',
            
			'phone.required' => 'Please enter Mobile Number',
			'phone.numeric' => 'Mobile number must be numeric',
			// 'phone.digits' => 'Mobile number must contain 11 digits',

		];
	}

}
