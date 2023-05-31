<?php
namespace Redlof\State\Controllers\Registration\Requests;

use Redlof\Core\Requests\Request;

class AddStep3Request extends Request {

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
			'registration_no' => 'bail|required|exists:registration_basic_details,registration_no',
			'residential_address' => 'bail|required|max:300',
			'state' => 'bail|required',
			'state.id' => 'bail|required|exists:states,id|numeric',

			'pincode' => 'bail|required|numeric|digits:6',

			'district_id' => 'bail|required||numeric',
			'block_id' => 'bail|required|numeric',
			'locality_id' => 'bail|required|numeric',
			'sub_block_id' => 'bail|required|numeric',
			'state_type' => 'bail|required',

			// 'sub_locality_id' => 'bail|required',
			// 'sub_sub_locality_id' => 'bail|required',
			// 'address_proof' => 'bail|required|in:ration_card,voter_card,driving_license,electricity_bill,aadhaar',
			// 'lat' => 'bail|required',
			// 'lng' => 'bail|required',
			// 'venue' => 'bail|required|max:255',

		];
	}

	public function messages() {

		return [
			'state.id.numeric' => 'Please select your state',
			'district_id.required' => 'Please select your district',
			'district_id.numeric' => 'Please select your district',
			'block_id.required' => 'Please select your block',
			'block_id.numeric' => 'Please select your block',
			'sub_block_id.required' => 'Please select your nagar panchayat',
			'sub_block_id.numeric' => 'Please select your nagar panchayat',
			'state_type.required' => 'Please select area type Urbun or Rural',
			'locality_id.required' => 'Please select your locality',
			'locality_id.numeric' => 'Please select your Ward/Panchayat',
			'sub_locality_id.required' => 'Please select your sub locality',
			'sub_sub_locality_id.required' => 'Please select your sub sub locality',
		];
	}

}