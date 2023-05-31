<?php
namespace Redlof\RoleAdmin\Controllers\Role\Requests;

use Redlof\Core\Requests\Request;

class DegreeRequest extends Request {

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
			'name' => 'required|unique:courses|regex:/^[\pL\s\-]+$/u',
		];
	}

	public function messages() {
		return [
			'name.required' => 'Enter Degree name.<br>',

			'name.unique' => 'Degree name already exists.<br>',
			
			'name.regex' => 'Enter valid Degree name.<br>',
		];
	}
}
