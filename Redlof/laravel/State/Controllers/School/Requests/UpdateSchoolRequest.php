<?php
namespace Redlof\State\Controllers\School\Requests;

use Redlof\Core\Requests\Request;

class UpdateSchoolRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'bail|required|min:3|max:50',
            'image' => 'bail|max:5000|mimes:jpeg,jpg,png',
            'udise' => 'bail|required|numeric|digits:11',
            'type' => 'bail|required|in:kg2,class1,class2,class3,class4,class5,class6,class7,class8,class9,class10,class11,class12',
            'school_type' => 'bail|required|in:co-educational,boys,girls',
            // 'eshtablished' => 'bail|required|numeric|digits:4|min:1750|max:2200',
            'phone' => 'bail|required',
            'admin_phone' => 'bail|required|numeric|regex:/^[789]\d{9}$/|digits:10',
            'email' => 'bail|email',
            'description' => 'max:1000',
            'medium' => 'bail|required',
            'levels' => 'required|array|min:1',
            'levels.*' => 'required',
            'rte_certificate_no' => 'bail|required',

            //'max_fees' => 'bail|required|numeric',
            //'website' => 'bail|required|url|min:4|max:40',
            // 'address' => 'bail|required|min:10|max:140',
            // 'state.id' => 'bail|required|numeric',
            // 'district_id' => 'bail|required|numeric',
            // 'locality_id' => 'bail|required|numeric',
            // // 'sub_locality_id' => 'bail|required|numeric',
            // // 'sub_sub_locality_id' => 'bail|required|numeric',
            // 'pincode' => 'bail|required|numeric|digits:6',
            // 'lat' => 'bail|required',
            // 'lng' => 'bail|required',
            // 'range0' => 'bail|required|min:1',
            // 'range1' => 'bail|required|min:1',
            // 'range3' => 'bail|required|min:1',
            // 'range6' => 'bail',
        ];

        if(isset($this->schooladmin)){

            $rules['admin_phone'] = 'bail|required|numeric|regex:/^[789]\d{9}$/|digits:10|unique:users,phone,'.$this->schooladmin['user_id'];
            $rules['email'] = 'bail|email|unique:users,email,'.$this->schooladmin['user_id'];
        }

        if(isset($this->id)){

            $rules['phone'] = 'bail|required|numeric|regex:/^[789]\d{9}$/|digits:10|unique:schools,phone,'.$this->id;
        }

        return $rules;
    }

    public function messages()
    {

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

            'medium.required' => 'Please select a language',

            'level.required' => 'Please select a entry class',
            'level.min' => 'Please select a entry class',

            'level.*.in' => 'Please select a entry class',

            'established.required' => 'Please add establishment year',
            'established.numeric' => 'Establishment may contain numbers only',
            'established.digits' => 'Establishment may contain atmost 4 digits',

            'phone.required' => 'Please add your phone',
            'phone.numeric' => 'Phone may contain numbers only',
            'phone.regex' => 'Phone may start with 7,8 or 9',
            'phone.digits' => 'Phone may contain atmost 10 digits',
            'phone.unique' => 'School phone number you entered has already been registered',

            'admin_phone.required' => 'Please add your admin phone',
            'admin_phone.numeric' => 'Admin phone may contain numbers only',
            'admin_phone.regex' => 'Admin phone may start with 7,8 or 9',
            'admin_phone.digits' => 'Admin phone may contain atmost 10 digits',
            'admin_phone.unique' => 'Admin phone number you entered has already been registered',

            'email.email' => 'Please add valid email',
            'email.unique' => 'The email you entered has already been registered',

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

            'rte_certificate_no.required' => 'Please add your RTE Certificate No.',
            'rte_certificate_no.alpha_num' => 'Please enter a valid RTE Certificate No.',

        ];
    }

}