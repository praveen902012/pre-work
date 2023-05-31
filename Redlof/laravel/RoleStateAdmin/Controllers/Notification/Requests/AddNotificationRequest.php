<?php
namespace Redlof\RoleStateAdmin\Controllers\Notification\Requests;

use Redlof\Core\Requests\Request;

class AddNotificationRequest extends Request {

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
			'content' => 'required|min:5',
			'subject' => 'required_if:type,email|min:5|max:60',
			'trigger_time' => 'required|after:yesterday',
			'expiry_time' => 'after:today',
		];
	}

	public function messages() {
		return [
			'name.required' => 'Enter author name.<br/>',
			'photo_name.required' => 'Select author image.<br/>',
			'photo_name.max' => 'Author image cannot be more than 5mb.<br/>',
		];
	}

}