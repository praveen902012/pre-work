<?php
namespace Redlof\RoleSchoolAdmin\Controllers\Student\Requests;

use Redlof\Core\Requests\Request;

class AddSubjectRequest extends Request {

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
			'level_id' => 'bail|required',
			'references.*.name' => 'bail|required|alpha|max:100',
		];
	}

	public function messages() {
		return [

			'level_id.required' => 'Please select a class',
			'references.*.name.required' => 'Subject name is required',
			'references.*.name.alpha' => 'Subject name may contain alphabet only',
			'references.*.name.max' => 'Subject name may not contain more than 100 characters',

		];
	}

}