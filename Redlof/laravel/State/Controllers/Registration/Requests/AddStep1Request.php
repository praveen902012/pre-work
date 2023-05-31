<?php
namespace Redlof\State\Controllers\Registration\Requests;

use Redlof\Core\Requests\Request;

class AddStep1Request extends Request
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
        return [
            'first_name' => 'bail|required|regex:/^([a-zA-Z\s]+)$/|max:30',
            'middle_name' => 'bail|regex:/^([a-zA-Z\s]+)$/|max:30',
            'last_name' => 'bail|regex:/^([a-zA-Z\s]+)$/|max:30',
            'gender' => 'bail|required|in:male,female,transgender',
            'dob.date' => 'bail|required|numeric|min:1|max:31',
            'dob.month' => 'bail|required|numeric|min:1|max:12',
            'dob.year' => 'bail|required|numeric|min:2000|max:2020',
            'level_id' => 'bail|required|exists:levels,id',
            // 'birth_proof' => 'bail|required|in:birth_ceritificate,aadhaar',
            'mobile' => 'bail|required|regex:/^[6789]\d{9}$/',
            'email' => 'bail|email|max:70',
            'aadhar_no' => 'bail|numeric|digits:12',
            'aadhar_enrollment_no' => 'bail|digits:28',
            'registration_no' => 'bail|required_with:id',
        ];
    }

    public function messages()
    {

        return [

            'dob.date.required' => 'Please select valid date for dob',
            'dob.date.numeric' => 'Selected date of birth is invalid',
            'dob.date.min' => 'Selected date of birth is invalid',
            'dob.date.max' => 'Selected date of birth is invalid',

            'dob.month.required' => 'Please select valid month for dob',
            'dob.month.numeric' => 'Selected date of birth is invalid',
            'dob.month.min' => 'Selected date of birth is invalid',
            'dob.month.max' => 'Selected date of birth is invalid',

            'dob.year.required' => 'Please select valid year for dob',
            'dob.year.numeric' => 'Selected date of birth is invalid',
            'dob.year.min' => 'Selected date of birth is invalid',
            'dob.year.max' => 'Selected date of birth is invalid',

            'level_id.required' => 'Please select level',
            'level_id.exists' => 'Selected level is invalid',

        ];
    }

}
