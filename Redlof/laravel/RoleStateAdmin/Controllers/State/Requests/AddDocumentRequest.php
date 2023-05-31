<?php
namespace Redlof\RoleStateAdmin\Controllers\State\Requests;

use Redlof\Core\Requests\Request;

class AddDocumentRequest extends Request {

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
			'title' => 'bail|required|min:4',
			'image_file' => 'bail|required',
			'doc_image_file' => 'bail|required',
		];
	}

	public function messages() {
		return [
			'title.required' => 'Please enter the Title',
			'title.min' => 'Title may contain atleast 4 characters',
			'image_file.required' => 'Please upload the document',
			'doc_image_file.required' => 'Please upload the document image',
		];
	}

}