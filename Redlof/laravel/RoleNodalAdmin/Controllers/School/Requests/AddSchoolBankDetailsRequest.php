<?php
namespace Redlof\RoleNodalAdmin\Controllers\School\Requests;

use Redlof\Core\Requests\Request;

class AddSchoolBankDetailsRequest extends Request
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
            'account_number' => 'required|min:6|max:20|regex:/^([0-9]+)$/|confirmed',
            'account_holder_name' => 'required|min:2|regex:/^([a-zA-Z ]+)$/|max:50',
            'bank_name' => 'required',
            'ifsc_code' => 'required_without:branch|alpha_num|min:11|max:11|confirmed',
            'branch' => 'required',
        ];
    }

    public function messages()
    {

        return [

        ];
    }

}