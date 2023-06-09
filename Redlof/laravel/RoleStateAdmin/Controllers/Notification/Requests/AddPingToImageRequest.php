<?php
namespace Redlof\RoleStateAdmin\Controllers\Notification\Requests;

use Redlof\Core\Requests\Request;

class AddPingToImageRequest extends Request {

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
			'access' => 'required',
			'photo' => 'required',
		];
	}

	public function messages() {
		return [
		];
	}

}