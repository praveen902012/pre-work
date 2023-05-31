<?php
namespace Redlof\State\Controllers\School\Requests;

use Redlof\Core\Requests\Request;

class SchoolResumeRequest extends Request {

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

			'udise_code' => 'bail|required|numeric|digits:11|exists:schools,udise',

		];
	}

	public function messages() {

		return [

		];
	}

}