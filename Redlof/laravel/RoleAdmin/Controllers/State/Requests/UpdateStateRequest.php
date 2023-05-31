<?php
namespace Redlof\RoleAdmin\Controllers\State\Requests;

use Redlof\Core\Requests\Request;

class UpdateStateRequest extends Request {

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
			'name' => 'bail|required|alpha|min:4|max:20',
			'language_id' => 'bail|required',
			'image' => 'max:10000|mimes:jpeg,jpg,png',

		];
	}

	public function messages() {
		return [
			'name.required' => 'Please add the state',
			'name.alpha' => 'State may contain just alphabets',
			'name.min' => 'State may contain atleast 4 characters',
			'name.max' => 'State may not contain more than 20 characters',
			'language_id.required' => 'Please add the language',
			'image.max' => 'Image sixe may not exceed 10 MB',
			'image.mimes' => 'Allowed Image formats are jpeg,jpg & png',
		];
	}
}
