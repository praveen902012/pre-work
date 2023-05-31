<?php
namespace Redlof\RoleSchoolAdmin\Controllers\Role\Requests;

use Redlof\Core\Requests\Request;

class UpdatePhotoRequest extends Request {

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
			'photo' => 'required|max:10000|mimes:jpeg,jpg,png',
		];
	}
}
