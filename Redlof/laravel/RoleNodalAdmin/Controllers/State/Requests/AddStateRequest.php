<?php
namespace Redlof\RoleNodalAdmin\Controllers\State\Requests;

use Redlof\Core\Requests\Request;

class AddStateRequest extends Request {

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
			'image' => 'bail|required|max:5000',
			'document' => 'bail|required|max:5000',
			'language_id' => 'bail|required|numeric',

		];
	}

	public function messages() {
		return [
			'name.required' => 'Please add the State',
			'name.alpha' => 'State may contain just alphabets',
			'name.min' => 'State may contain atleast 4 characters',
			'name.max' => 'State may not contain more than 20 characters',
			'image.required' => 'Please add the image',
			'image.max' => 'Logo may not contain more than 5mb',
			'document.required' => 'Please add the Document',
			'document.max' => 'documents may not contain more than 5mb',
			'language_id.required' => 'Please add Language ID',
			'language_id.numeric' => 'Language ID may contain just numbers',

		];
	}

}