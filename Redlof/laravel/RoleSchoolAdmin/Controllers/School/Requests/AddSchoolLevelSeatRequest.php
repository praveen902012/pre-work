<?php
namespace Redlof\RoleSchoolAdmin\Controllers\School\Requests;

use Redlof\Core\Requests\Request;

class AddSchoolLevelSeatRequest extends Request {

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
			'*.total_seats' => 'bail|required|numeric|min:1|max:1000',
			'*.available_seats' => 'bail|required|numeric|min:1|max:1000',
			'*.level_id' => 'required',

		];
	}

	public function messages() {

		return [
			'*.total_seats.required' => 'Total seats is empty for one of the class',
			'*.total_seats.numeric' => 'Total seats mumber be numeric',
			'*.total_seats.min' => 'Total seats cannot be less than 1',
			'*.total_seats.max' => 'Total seats cannot be greater than 1000',

			'*.available_seats.required' => 'Available seats is empty for one of the class',
			'*.available_seats.numeric' => 'Available seats mumber be numeric',
			'*.available_seats.min' => 'Available seats cannot be less than 1',
			'*.available_seats.max' => 'Available seats cannot be greater than or equal to total seats',

		];
	}

}