<?php
namespace Redlof\RoleAdmin\Controllers\DataRepo\Requests;

use Redlof\Core\Requests\Request;

class AddLanguageRequest extends Request {

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
			'name' => 'bail|required|alpha|min:4|max:20|unique:languages',

		];
	}

	public function messages() {
		return [
			'name.required' => 'Please add the language',
			'name.unique' => 'Language already exists',
			'name.alpha' => 'Language may contain just alphabets',
			'name.min' => 'Language may contain atleast 4 characters',
			'name.max' => 'Language may not contain more than 20 characters',
		];
	}

}