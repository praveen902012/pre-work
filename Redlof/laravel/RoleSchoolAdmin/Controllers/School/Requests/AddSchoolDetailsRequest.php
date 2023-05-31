<?php
namespace Redlof\RoleSchoolAdmin\Controllers\School\Requests;

use Redlof\Core\Requests\Request;

class AddSchoolDetailsRequest extends Request {

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
			'feestructure.*.tution_fee' => 'bail|required|numeric|min:0|max:1000000',
			'feestructure.*.other_fee' => 'bail|required|numeric|min:0|max:1000000',
			'seatinfo.*.alloted_seats_2015' => 'bail|required|numeric|min:0|max:100',
			'seatinfo.*.alloted_seats_2016' => 'bail|required|numeric|min:0|max:100',
			'seatinfo.*.alloted_seats_2017' => 'bail|required|numeric|min:0|max:100',
			'seatinfo.*.alloted_seats_2018' => 'bail|required|numeric|min:0|max:100',
			'seatinfo.*.available_seats' => 'bail|required|numeric|min:1|max:100',
		];
	}

	public function messages() {

		return [

			'seatinfo.*.alloted_seats_2015.required' => 'Enter seats alloted for the year 2015 ',
			'seatinfo.*.alloted_seats_2015.min' => ' Seats alloted for the year 2015 cannot be less than 1',
			'seatinfo.*.alloted_seats_2015.max' => ' Seats alloted for the year 2015 cannot be more than 100',

			'seatinfo.*.alloted_seats_2016.required' => 'Enter seats alloted for the year 2016 ',
			'seatinfo.*.alloted_seats_2016.min' => ' Seats alloted for the year 2016 cannot be less than 1',
			'seatinfo.*.alloted_seats_2016.max' => ' Seats alloted for the year 2016 cannot be more than 100',

			'seatinfo.*.alloted_seats_2017.required' => 'Enter seats alloted for the year 2017 ',
			'seatinfo.*.alloted_seats_2017.min' => ' Seats alloted for the year 2017 cannot be less than 1',
			'seatinfo.*.alloted_seats_2017.max' => 'Seats alloted for the year 2017 cannot be more than 100',

			'seatinfo.*.alloted_seats_2018.required' => 'Enter seats alloted for the year 2018 ',
			'seatinfo.*.alloted_seats_2018.min' => ' Seats alloted for the year 2018 cannot be less than 1',
			'seatinfo.*.alloted_seats_2018.max' => 'Seats alloted for the year 2018 cannot be more than 100',

			'seatinfo.*.available_seats.required' => 'Seat taken is required ',
			'seatinfo.*.available_seats.min' => 'Seat taken cannot be less than 1',
			'seatinfo.*.available_seats.max' => 'Seat taken cannot be more than 100',

		];
	}

}