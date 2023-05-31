<?php

namespace Redlof\RoleStateAdmin\Controllers\School\Requests;

use Redlof\Core\Requests\Request;

class RecheckRequest extends Request
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
            'recheck_reason' => 'bail|required|min:3|max:500',

        ];
    }

    public function messages()
    {

        return [

            'recheck_reason.required' => 'Please add the reason',
            'recheck_reason.min' => 'Reason may contain atleast 4 characters',
            'recheck_reason.max' => 'Reason may not contain more than 500 characters',

        ];
    }

}
