<?php
namespace Redlof\RoleStateAdmin\Controllers\Role\Requests;

use Redlof\Core\Requests\Request;

class AddNodalAdminRequest extends Request
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
            'district_id' => 'bail|required',
            'first_name' => 'bail|nullable|alpha|max:100',
            'last_name' => 'bail|nullable|alpha|max:100',
            'email' => 'bail|nullable|email|unique:users,email',
            'phone' => 'bail|nullable|regex:/^[789]\d{9}$/',
        ];
    }

    public function messages()
    {
        return [
            'district_id.required' => 'Please select the district',
            'first_name.required' => 'First name is required',
            'first_name.alpha' => 'First name may contain alphabet only',
            'first_name.max' => 'First name may not contain more than 100 characters',
            'last_name.max' => 'Last name may not contain more than 100 characters',
            'last_name.alpha' => 'Last name may contain alphabet only',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Provide a valid Email',
            'email.unique' => 'This email has already been registered to the platform',
            'phone.required' => 'Phone Number is required',
        ];
    }

}
