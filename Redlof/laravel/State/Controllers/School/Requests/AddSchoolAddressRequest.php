<?php
namespace Redlof\State\Controllers\School\Requests;

use Redlof\Core\Requests\Request;

class AddSchoolAddressRequest extends Request {

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
			// 'name' => 'bail|required|min:3|max:50',
			// 'image' => 'bail|max:5000|mimes:jpeg,jpg,bmp,png',
			// 'udise' => 'bail|required|unique:schools|numeric|digits:11',
			// 'type' => 'bail|required|in:kg2,class1,class2,class3,class4,class5,class6,class7,class8',
			// 'school_type' => 'bail|required|in:co-educational,boys,girls',
			// // 'eshtablished' => 'bail|required|numeric|digits:4|min:1750|max:2200',
			// 'phone' => 'bail|required|numeric|regex:/^[789]\d{9}$/|digits:10',
			// 'admin_phone' => 'bail|required|numeric|regex:/^[789]\d{9}$/|digits:10|unique:users,phone',
			// 'admin_email' => 'bail|email|unique:users,email',
			//'max_fees' => 'bail|required|numeric',
			//'website' => 'bail|required|url|min:4|max:40',
			'address' => 'bail|required|min:10|max:140',
			// 'state_id' => 'bail|required|numeric',
			'district_id' => 'bail|required|numeric',
			'locality_id' => 'bail|required|numeric',
			'sub_block_id' => 'bail|required|numeric',
			'block_id' => 'bail|required|numeric',
			// 'venue' => 'bail|required',
			// 'cluster_id' => 'bail|required|numeric',

			// 'sub_locality_id' => 'bail|required|numeric',
			// // 'sub_sub_locality_id' => 'bail|required|numeric',
			'pincode' => 'bail|required|numeric|digits:6',
			// 'lat' => 'bail|required',
			// 'lng' => 'bail|required',
			// 'range0' => 'bail|required|min:1',
			// 'range1' => 'bail|required|min:1',
			// 'range3' => 'bail|required|min:1',
			// 'range6' => 'bail',
		];
	}

	public function messages() {

		return [

			'udise.unique' => 'The UDISE code you entered has already been registered',
			'range0.min' => 'Select atleast one region under the range 0f 0-1 kms',
			'range0.required' => 'Select atleast one region under the range 0f 0-1 kms',
			'range1.min' => 'Select atleast one region under the range 0f 1-3 kms',
			'range1.required' => 'Select atleast one region under the range 0f 1-3 kms',
			'range3.min' => 'Select atleast one region under the range 0f 3-6 kms',
			'range3.required' => 'Select atleast one region under the range 0f 3-6 kms',
			// 'range6.min' => 'Select atleast one region under the range 0f beyond 6 kms',

			'name.required' => 'Please add the school',
			'name.min' => 'School may contain atleast 4 characters',
			'name.max' => 'School may not contain more than 50 characters',

			'image.max' => 'Size of logo cannot exceed 1MB',

			'udise.required' => 'Please add UDISE',
			'udise.numeric' => 'UDISE may contain numbers only',
			'udise.digits' => 'UDISE may contain atmost 11 digits',

			'medium.required' => 'Please add Medium',
			'medium.numeric' => 'Medium may contain numbers only',

			'established.required' => 'Please add establishment year',
			'established.numeric' => 'Establishment may contain numbers only',
			'established.digits' => 'Establishment may contain atmost 4 digits',

			'phone.required' => 'Please add your phone',
			'phone.numeric' => 'Phone may contain numbers only',
			'phone.regex' => 'Phone may start with 6,7,8 or 9',
			'phone.digits' => 'Phone may contain atmost 10 digits',

			'admin_phone.required' => 'Please add your admin phone',
			'admin_phone.numeric' => 'Admin phone may contain numbers only',
			'admin_phone.regex' => 'Admin phone may start with 7,8 or 9',
			'admin_phone.digits' => 'Admin phone may contain atmost 10 digits',
			'admin_phone.unique' => 'Admin phone number you entered has already been registered',

			'admin_email.email' => 'Please add valid email',
			'admin_email.unique' => 'The email you entered has already been registered',

			'website.required' => 'Please add your website',
			'website.url' => 'Please add a valid website',
			'website.min' => 'Website may contain atleast 4 characters',
			'website.max' => 'Website may not contain more than 40 characters',

			'address.required' => 'Please add your address',
			'address.regex' => 'Address may contain alphabets and numbers',
			'address.min' => 'Address may contain atleast 10 characters',
			'address.max' => 'Address may not contain more than 140 characters',

			'block_id.required' => 'Please Select Block',
			'block_id.numeric' => 'Please select Block from the dropdown only',

			'sub_block_id.required' => 'Please Select Sub-Block',
			'sub_block_id.numeric' => 'Please select Sub-Block from the dropdown only',

			'state_id.required' => 'Please select the state',
			'state_id.numeric' => 'Please select state from the dropdown only',

			'district_id.required' => 'Please select the disrict',
			'district_id.numeric' => 'Please select district from the dropdown only',

			'locality_id.required' => 'Please select Ward/Gram-Panchayat',
			'locality_id.numeric' => 'Please select Ward/Gram-Panchayat from the dropdown only',

			'cluster_id.required' => 'Please select your cluster',
			'cluster_id.numeric' => 'Please select your cluster',

			'sub_locality.required' => 'Please select the Sub locality',
			'sub_locality_id.numeric' => 'Please select Sub locality from the dropdown only',

			'sub_sub_locality.required' => 'Please select the Sub sub locality',
			'sub_sub_locality_id.numeric' => 'Please select Sub locality from the dropdown only',

			'pincode.required' => 'Please add your pincode',
			'pincode.numeric' => 'Pincode may contain numbers only',
			'pincode.digits' => 'Pincode may contain atmost 6 digits only',


		];
	}

}