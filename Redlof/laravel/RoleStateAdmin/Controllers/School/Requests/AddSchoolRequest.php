<?php
namespace Redlof\RoleStateAdmin\Controllers\School\Requests;

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
			'name' => 'bail|required|regex:/^([a-zA-Z0-9 ]+)$/|min:4|max:50',
			'image' => 'bail|max:1024|mimes:jpeg,jpg,bmp,png',
			'udise' => 'bail|required|numeric|digits:11',
			//'medium' => 'bail|required|numeric',
			'eshtablished' => 'bail|required|numeric|digits:4',
			'phone' => 'bail|required|numeric|regex:/^[789]\d{9}$/|digits:10',
			'admin_phone' => 'bail|required|numeric|regex:/^[789]\d{9}$/|digits:10',
			'admin_email' => 'bail|required|email',
			'max_fees' => 'bail|required|numeric',
			'website' => 'bail|required|url|min:4|max:40',
			'address' => 'bail|required|min:10|max:140',
			'state.id' => 'bail|required|numeric',
			'district_id' => 'bail|required|numeric',
			'locality_id' => 'bail|required|numeric',
			'sub_locality_id' => 'bail|required|numeric',
			'sub_sub_locality_id' => 'bail|required|numeric',
			'pincode' => 'bail|required|numeric|digits:6',
			'lat' => 'bail|required',
			'lng' => 'bail|required',
		];
	}

	public function messages() {

		return [

			'name.required' => 'Please add the school',
			'name.regex' => 'School may contain alphabets and numbers',
			'name.min' => 'School may contain atleast 4 characters',
			'name.max' => 'School may not contain more than 50 characters',

			'image.required' => 'Please add logo',
			'image.max' => 'Size of logo cannot exceed 1MB',

			'udise.required' => 'Please add UDISE',
			'udise.numeric' => 'UDISE may contain numbers only',
			'udise.digits' => 'UDISE may contain atmost 11 digits',

			'established.required' => 'Please add establishment year',
			'established.numeric' => 'Establishment may contain numbers only',
			'established.digits' => 'Establishment may contain atmost 4 digits',

			'phone.required' => 'Please add your phone',
			'phone.numeric' => 'Phone may contain numbers only',
			'phone.regex' => 'Phone may start with 7,8 or 9',
			'phone.digits' => 'Phone may contain atmost 10 digits',

			'admin_phone.required' => 'Please add your admin phone',
			'admin_phone.numeric' => 'Admin phone may contain numbers only',
			'admin_phone.regex' => 'Admin phone may start with 7,8 or 9',
			'admin_phone.digits' => 'Admin phone may contain atmost 10 digits',

			'admin_email.required' => 'Please add your admin email',
			'admin_email.email' => 'Please add valid email',

			'max_fees.required' => 'Please add max fees',
			'max_fees.numeric' => 'Fee may contain numbers only',

			'website.required' => 'Please add your website',
			'website.url' => 'Please add a valid website',
			'website.min' => 'Website may contain atleast 4 characters',
			'website.max' => 'Website may not contain more than 40 characters',

			'address.required' => 'Please add your address',
			'address.regex' => 'Address may contain alphabets and numbers',
			'address.min' => 'Address may contain atleast 10 characters',
			'address.max' => 'Address may not contain more than 140 characters',

			'state_id.required' => 'Please add the state ID',
			'state_id.numeric' => 'State ID may contain numbers only',

			'disrict_id.required' => 'Please add the disrict ID',
			'disrict_id.numeric' => 'District ID may contain numbers only',

			'locality_id.required' => 'Please add the locality ID',
			'locality_id.numeric' => 'Locality ID may contain numbers only',

			'sub_locality.required' => 'Please add the Sub locality',
			'sub_locality_id.numeric' => 'Sub locality ID may contain numbers only',

			'sub_sub_locality.required' => 'Please add the Sub sub locality',
			'sub_sub_locality_id.numeric' => 'Sub sub locality ID may contain numbers only',

			'
			pincode.required' => 'Please add your pincode',
			'pincode.numeric' => 'Pincode may contain numbers only',
			'pincode.digits' => 'Pincode may contain atmost 6 digits only',

			'lat.required' => 'Please add your latitude',

			'lng.required' => 'Please add your longitude',
		];
	}

}
