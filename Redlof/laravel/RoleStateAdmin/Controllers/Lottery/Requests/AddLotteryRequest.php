<?php
namespace Redlof\RoleStateAdmin\Controllers\Lottery\Requests;

use Redlof\Core\Requests\Request;

class AddLotteryRequest extends Request {

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

		$rules = [
			'lottery_announcement' => 'bail|required|date|after:stu_reg_end_date',
			'enrollment_end_date' => 'bail|required|date|after:lottery_announcement',
			'session_year' => 'bail|required|numeric|min:2018|digits:4|max:3000',
			'stu_reg_start_date' => 'bail|required|date|after:reg_start_date',
			'stu_reg_end_date' => 'bail|required|date|after:stu_reg_start_date',
		];

		if($this->is_school_reg == 'Yes'){
			$rules['reg_start_date'] = 'bail|required|date|after:yesterday';
			$rules['reg_end_date'] = 'bail|required|date|after:reg_start_date';
		}

		$previous_sessions = \Models\ApplicationCycle::get()->pluck('session_year')->toArray();

		if(in_array($this->session_year, $previous_sessions)){

			$rules['cycle'] = 'bail|required';
		};

		return $rules;
	}

	public function messages() {

		return [

			'reg_start_date.required' => 'Please provide registration start date',
			'reg_start_date.after' => 'School registration start date may start only today or afterwards',

			'reg_end_date.after' => 'School registration end date may come after registration start date',

			'stu_reg_start_date.required' => 'Please provide student registration start date',
			'stu_reg_start_date.after' => 'Student registration start date may start only after school registration start date',

			'stu_reg_end_date.after' => 'Student registration end date may come after registration start date',

			'lottery_announcement.required' => 'Please provide lottery announcement date',
			'lottery_announcement.after' => 'Lottery announcement date may come after student registration end date',

			'session_year.required' => 'Please provide session year',

			'cycle.required' => 'Please select cycle',
		];
	}
}
