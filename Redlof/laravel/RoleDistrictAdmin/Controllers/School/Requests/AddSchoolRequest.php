<?php
namespace Redlof\RoleDistrictAdmin\Controllers\School\Requests;

use Redlof\Core\Requests\Request;

class AddSchoolRequest extends Request {

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
			'name' => 'bail|required|regex:/^([a-zA-Z0-9 ]+)$/|min:4|max:20',
			'logo' => 'bail|required|max:5000',
			'phone' => 'bail|required|numeric',
			'website' => 'bail|required|url|min:4|max:40',
			'address' => 'bail|required|regex:/^([a-zA-Z0-9 ]+)$/|min:10|max:40',
			'state_id' => 'bail|required|numeric|min:1|max:20',
			'locality' => 'bail|required|alpha|min:4|max:20',
			'sub_locality' => 'bail|required|alpha|min:4|max:20',
			'sub_sub_locality' => 'bail|required|alpha|min:4|max:20',
			'lat' => 'bail|required|numeric',
			'lng' => 'bail|required|numeric',
			'pincode' => 'bail|required|numeric',
			'status' => 'bail|required|alpha|min:4|max:10',
			'application_status' => 'bail|required|alpha|min:4|max:10',
		];
	}

	public function messages() {

		return [
			'name.required' => 'Please add the school',
			'name.regex' => 'School may contain alphabets and numbers',
			'name.min' => 'School may contain atleast 4 characters',
			'name.max' => 'School may not contain more than 20 characters',

			'logo.required' => 'Please add logo',
			'logo.max' => 'Size of logo can not exceed 5MB',

			'phone.required' => 'Please add your phone',
			'phone.numeric' => 'Phone may contain numbers only',

			'website.required' => 'Please add your website',
			'website.min' => 'Website may contain atleast 4 characters',
			'website.max' => 'Website may not contain more than 40 characters',

			'address.required' => 'Please add your address',
			'address.regex' => 'Address may contain alphabets and numbers',
			'address.min' => 'Address may contain atleast 10 characters',
			'address.max' => 'Address may not contain more than 40 characters',

			'state_id.required' => 'Please add the state ID',
			'state_id.numeric' => 'State ID may contain numbers only',
			'state_id.min' => 'State ID may contain 1 as least value',

			'locality.required' => 'Please add the locality',
			'locality.regex' => 'Locality may contain alphabets only',
			'locality.min' => 'Locality may contain atleast 4 characters',
			'locality.max' => 'Locality may not contain more than 20 characters',

			'sub_locality.required' => 'Please add the Sub locality',
			'sub_locality.regex' => 'Sub locality may contain alphabets only',
			'sub_locality.min' => 'Sub locality may contain atleast 4 characters',
			'sub_locality.max' => 'Sub locality may not contain more than 20 characters',

			'sub_sub_locality.required' => 'Please add the Sub sub locality',
			'sub_sub_locality.regex' => 'Sub sub locality may contain alphabets only',
			'sub_sub_locality.min' => 'Sub sub locality may contain atleast 4 characters',
			'sub_sub_locality.max' => 'Sub sub locality may not contain more than 20 characters',

			'lat.required' => 'Please add your latitude',
			'lat.numeric' => 'Latitude may contain numbers only',

			'lng.required' => 'Please add your longitude',
			'lng.numeric' => 'Longitude may contain numbers only',

			'pincode.required' => 'Please add your pincode',
			'pincode.numeric' => 'Pincode may contain numbers only',

			'status.required' => 'Please add the status',
			'status.alpha' => 'Status may contain alphabets only',
			'status.min' => 'Status may contain atleast 4 characters',
			'status.max' => 'Status may not contain more than 10 characters',

			'application_status.required' => 'Please add the application status',
			'application_status.alpha' => 'Application status may contain alphabets and numbers',
			'application_status.min' => 'Application status may contain atleast 4 characters',
			'application_status.max' => 'Application status may not contain more than 10 characters',

		];
	}
}
