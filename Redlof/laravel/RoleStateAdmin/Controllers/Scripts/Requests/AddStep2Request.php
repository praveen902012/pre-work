<?php
namespace Redlof\StateAdmin\Controllers\Scripts\Requests;

use Redlof\Core\Requests\Request;

class AddStep2Request extends Request
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
            //add array validation
            'parent_type' => 'bail|required|array|min:1',
            'registration_no' => 'bail|required|exists:registration_basic_details,registration_no',

            'father.parent_name' => 'bail|required_if:parent_type.father, true|regex:/^([a-zA-Z.\s]+)$/|max:150',
            // 'father.parent_mobile_no' => 'bail|required_if:parent_type.father, true|regex:/^[789]\d{9}$/',
            'father.parent_profession' => 'bail|required_if:parent_type.father, true|in:government,business,private,other,home-maker',

            'mother.parent_name' => 'bail|required_if:parent_type.mother, true|regex:/^([a-zA-Z\s]+)$/|max:150',
            // 'mother.parent_mobile_no' => 'bail|required_if:parent_type.mother, true|regex:/^[789]\d{9}$/',
            'mother.parent_profession' => 'bail|required_if:parent_type.mother, true|in:government,business,private,other,home-maker',

            'guardian.parent_name' => 'bail|required_if:parent_type.guardian, true|regex:/^([a-zA-Z\s]+)$/|max:150',
            // 'guardian.parent_mobile_no' => 'bail|required_if:parent_type.guardian, true|regex:/^[789]\d{9}$/',
            'guardian.parent_profession' => 'bail|required_if:parent_type.guardian, true|in:government,business,private,other,home-maker',

            // 'parent_id_proof' => 'bail|required|in:aadhar,pan,voter,driving_licence,aadhaar',
            'category' => 'bail|required|in:ews,dg',

            'certificate_details.ews_type' => 'bail|required_if:category,ews|in:income_certificate,bpl_card',

            // For income_certificate

            'certificate_details.ews_income' => 'bail|required_if:certificate_details.ews_type,income_certificate|numeric|min:0|max:55000',

            'certificate_details.ews_tahsil_name' => 'bail|required_if:certificate_details.ews_type,income_certificate|regex:/^([a-zA-Z.\s]+)$/|max:150',

            'certificate_details.ews_cerificate_no' => 'bail|required_if:certificate_details.ews_type,income_certificate|max:150',

            // For bpl_card

            'certificate_details.ews_cerificate_no' => 'bail|required_if:certificate_details.ews_type,bpl_card|max:150',

            'certificate_details.ews_tahsil_name' => 'bail|required_if:certificate_details.ews_type,bpl_card|regex:/^([a-zA-Z.\s]+)$/|max:150',

            // 'certificate_details.bpl_ews' => 'bail|required_if:category,bpl|in:income_certificate,other_bpl',

            'certificate_details.dg_type' => 'bail|required_if:category,dg|in:sc,st,obc,orphan,with_hiv,divorced_women,widow_women,kodh,disable,disable_parents',

            // 'certificate_details.bpl_cerificate' => 'bail|required_if:category,bpl',

            'certificate_details.bpl_cerificate_date' => 'bail|required_if:certificate_details.ews_type,income_certificate|numeric|min:1|max:31',

            'certificate_details.bpl_cerificate_month' => 'bail|required_if:certificate_details.ews_type,income_certificate|numeric|min:1|max:12',

            'certificate_details.bpl_cerificate_year' => 'bail|required_if:certificate_details.ews_type,income_certificate|numeric|min:2022|max:2023',

            // 'certificate_details.dg_proof' => 'bail|required_if:category,dg|in:caste_certificate,medical_certificate,relevant_certificate',

            'certificate_details.dg_tahsil_name' => 'bail|required_if:certificate_details.dg_type,sc|required_if:certificate_details.dg_type,st|required_if:certificate_details.dg_type,obc|regex:/^([a-zA-Z.\s]+)$/|max:150',

            'certificate_details.dg_income_tahsil_name' => 'bail|required_if:certificate_details.dg_type,obc|regex:/^([a-zA-Z.\s]+)$/|max:150',
            'certificate_details.dg_income_cerificate' => 'bail|required_if:certificate_details.dg_type,obc|max:150',

            'certificate_details.dg_cerificate' => 'bail|required_if:category,dg',

            'certificate_details.dg_cerificate_date' => 'bail|required_if:certificate_details.dg_type,obc|numeric|min:1|max:31',

            'certificate_details.dg_cerificate_month' => 'bail|required_if:certificate_details.dg_type,obc|numeric|min:1|max:12',

            'certificate_details.dg_cerificate_year' => 'bail|required_if:certificate_details.dg_type,obc|numeric|min:2022|max:2023',

        ];
    }

    public function messages()
    {

        return [

            'father.parent_name.required_if' => 'Enter fathers name',
            'mother.parent_name.required_if' => 'Enter mothers name',
            'guardian.parent_name.required_if' => 'Enter guardians name',

            'father.parent_name.regex' => 'Enter valid fathers name',
            'mother.parent_name.regex' => 'Enter valid mothers name',
            'guardian.parent_name.regex' => 'Enter valid guardians name',

            'father.parent_name.max' => 'Enter fathers name cannot be greater than 150 characters',
            'mother.parent_name.max' => 'Enter mothers name cannot be greater than 150 characters',
            'guardian.parent_name.max' => 'Enter guardians name cannot be greater than 150 characters',

            'certificate_details.ews_type.required_if' => 'Please select EWS certificate Type',

            'certificate_details.ews_income.required_if' => 'Please enter the family anual income',
            'certificate_details.ews_income.max' => 'Family annual income should not be more than 55000',

            'certificate_details.ews_tahsil_name.required_if' => 'Please enter the tahsil name',
            'certificate_details.ews_tahsil_name.regex' => 'Invalid tahsil name',

            'certificate_details.ews_cerificate_no.required_if' => 'Please enter the income  cerificate number',

            'certificate_details.ews_cerificate_no.alpha_num' => 'Cerificate number may only contain letters and numbers',

            'certificate_details.bpl_ews.required_if' => 'Please enter BPL(EWS) certificate details',
            'certificate_details.bpl_ews.in' => 'Invalid BPL(EWS) certificate details',

            'certificate_details.dg_type.required_if' => 'Please enter DG certificate details',
            'certificate_details.dg_type.in' => 'Invalid DG certificate details',

            'certificate_details.bpl_cerificate.in.required_if' => 'Please enter BPL certificate details',

            'certificate_details.bpl_cerificate_date.required_if' => 'Please select valid date for Income certificate issue date',
            'certificate_details.bpl_cerificate_date.numeric' => 'Invalid Income certificate issue date',
            'certificate_details.bpl_cerificate_date.min' => 'Invalid Income certificate issue date',
            'certificate_details.bpl_cerificate_date.max' => 'Invalid Income certificate issue date',

            'certificate_details.bpl_cerificate_month.required_if' => 'Please select valid date for Income certificate issue month',
            'certificate_details.bpl_cerificate_month.numeric' => 'Invalid Income certificate issue month',
            'certificate_details.bpl_cerificate_month.min' => 'Invalid Income certificate issue month',
            'certificate_details.bpl_cerificate_month.max' => 'Invalid Income certificate issue month',

            'certificate_details.bpl_cerificate_year.required_if' => 'Please select valid date for Income certificate issue year',
            'certificate_details.bpl_cerificate_year.numeric' => 'Invalid Income certificate issue year',
            'certificate_details.bpl_cerificate_year.min' => 'Invalid Income certificate issue year',
            'certificate_details.bpl_cerificate_year.max' => 'Invalid Income certificate issue year',

            'certificate_details.dg_proof.required_if' => '',
            'certificate_details.dg_proof.in' => '',

            'certificate_details.dg_income_tahsil_name.required_if' => 'Please enter the tahsil name',
            'certificate_details.dg_income_cerificate.required_if' => 'Please enter the income certificate number',
            'certificate_details.dg_income_cerificate.alpha_num' => 'Income certificate number may only contain letters and numbers.',

            'certificate_details.dg_cerificate.required_if' => 'Please enter the DG certificate number',
            'certificate_details.dg_cerificate.alpha_num' => 'DG certificate number may only contain letters and numbers.',
            'certificate_details.dg_tahsil_name.required_if' => 'Please enter the tahsil name',

            'certificate_details.dg_cerificate_date.required_if' => 'Please select valid date for DG certificate issue date',
            'certificate_details.dg_cerificate_date.numeric' => 'Invalid DG certificate issue date',
            'certificate_details.dg_cerificate_date.min' => 'Invalid DG certificate issue date',
            'certificate_details.dg_cerificate_date.max' => 'Invalid DG certificate issue date',

            'certificate_details.dg_cerificate_month.required_if' => 'Please select valid date for DG certificate issue month',
            'certificate_details.dg_cerificate_month.numeric' => 'Invalid DG certificate issue month',
            'certificate_details.dg_cerificate_month.min' => 'Invalid DG certificate issue month',
            'certificate_details.dg_cerificate_month.max' => 'Invalid DG certificate issue month',

            'certificate_details.dg_cerificate_year.required_if' => 'Please select valid date for DG certificate issue year',
            'certificate_details.dg_cerificate_year.numeric' => 'Invalid DG certificate issue year',
            'certificate_details.dg_cerificate_year.min' => 'Invalid DG certificate issue year',
            'certificate_details.dg_cerificate_year.max' => 'Invalid DG certificate issue year',
        ];
    }

}
