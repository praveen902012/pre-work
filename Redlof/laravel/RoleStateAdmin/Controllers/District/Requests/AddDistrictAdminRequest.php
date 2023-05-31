<?php
namespace Redlof\RoleStateAdmin\Controllers\District\Requests;

use Redlof\Core\Requests\Request;

class AddDistrictAdminRequest extends Request {

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

			'first_name' => 'bail|required|regex:/^([a-zA-Z0-9 ]+)$/|min:4|max:50',
			'last_name' => 'bail|required|regex:/^([a-zA-Z0-9 ]+)$/|min:4|max:50',
			'email' => 'bail|required|email',
			'phone' => 'bail|required|numeric|digits:10|regex:/^[789]\d{9}$/',
		];
	}

	public function messages() {
		return [

			'first_name.required' => 'Please add First Name',
			'first_name.regex' => 'First Name may contain alphabets and numbers',
			'first_name.min' => 'First Name may contain atleast 4 characters',
			'first_name.max' => 'First Name may not contain more than 50 characters',

			'last_name.required' => 'Please add Last Name',
			'last_name.regex' => 'Last Name may contain alphabets and numbers',
			'last_name.min' => 'Last Name may contain atleast 4 characters',
			'last_name.max' => 'Last Name may not contain more than 50 characters',

			'email.required' => 'Email is required',
			'email.email' => 'Provide a valid Email',

			'phone.required' => 'Please add your phone',
			'phone.numeric' => 'Phone may contain numbers only',
			'phone.regex' => 'Phone may start with 7,8 or 9',
			'phone.digits' => 'Phone may contain atmost 10 digits',
		];
	}

}