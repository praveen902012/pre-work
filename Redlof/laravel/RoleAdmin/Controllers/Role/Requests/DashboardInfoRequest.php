<?php
namespace Redlof\RoleAdmin\Controllers\Role\Requests;

use Redlof\Core\Requests\Request;

class DashboardInfoRequest extends Request {

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
			'start_date' => 'bail|required|before:today',

			'end_date' => 'bail|required|after:start_date',

		];
	}

	public function messages() {
		return [
			'start_date.required' => 'Select start date',

			'start_date.before' => 'Select valid start date',

			'end_date.required' => 'Select end date ',

			'end_date.after' => 'Select valid end date ',
		];
	}
}
