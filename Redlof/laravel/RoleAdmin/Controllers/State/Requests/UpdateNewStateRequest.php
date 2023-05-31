<?php
namespace Redlof\RoleAdmin\Controllers\State\Requests;

use Redlof\Core\Requests\Request;

class UpdateNewStateRequest extends Request {

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
			'state_id' => 'bail|required',
			'language' => 'bail|required',
			'image' => 'max:10000|mimes:jpeg,jpg,png',

		];
	}

	public function messages() {
		return [
			'state_id.required' => 'Please select the state',
			'language.required' => 'Please select the language',
			'image.max' => 'Image sixe may not exceed 10 MB',
			'image.mimes' => 'Allowed Image formats are jpeg,jpg & png',
		];
	}
}
