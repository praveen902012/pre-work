<?php
namespace Redlof\RoleSchoolAdmin\Controllers\School\Requests;

use Redlof\Core\Requests\Request;

class AddSchoolLevelFeeRequest extends Request {

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
			'*.dress_fee' => 'bail|required|numeric|min:0|max:1000000',
			'*.books_fee' => 'bail|required|numeric|min:0|max:1000000',
			'*.other_fee' => 'bail|required|numeric|min:0|max:1000000',

		];
	}

	public function messages() {

		return [
			'*.dress_fee.required' => 'Dress Fee is empty for one of the class',
			'*.dress_fee.numeric' => 'Dress Fee mumber be numeric',
			'*.dress_fee.min' => 'Dress Fee cannot be less than INR 0',
			'*.dress_fee.max' => 'Dress Fee cannot be greater than INR 1000000',

			'*.books_fee.required' => 'Book Fee is empty for one of the class',
			'*.books_fee.numeric' => 'Book Fee mumber be numeric',
			'*.books_fee.min' => 'Book Fee cannot be less than INR 0',
			'*.books_fee.max' => 'Book Fee cannot be greater than INR 1000000',

			'*.other_fee.required' => 'Other Fee is empty for one of the class',
			'*.other_fee.numeric' => 'Other Fee mumber be numeric',
			'*.other_fee.min' => 'Other Fee cannot be less than INR 0',
			'*.other_fee.max' => 'Other Fee cannot be greater than INR 1000000',
		];
	}

}