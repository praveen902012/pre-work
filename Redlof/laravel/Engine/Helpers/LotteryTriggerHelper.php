<?php
namespace Helpers;

class LotteryTriggerHelper {

	static function triggerLottery($state_id, $type = "auto") {

		// var_dump($type, $state_id);
		//set the iteration as 1
		//set pending lot as empty array

		//for this particular state check if there is any new application cycle
		//if yes type is manual
		//update the trigger_type
		//get all the registered applicant for the state
		//where status is applied
		//along with the registratoin cycle details
		// where the application cycle id is the same as the selected application cycle

		//while iteration is less than 4

		//if count of currenlty processing lot is greater than 0
		//then randomly select one of the applicant
		//and get the school which had been set as the current iteration

		//if there are seats left for the level which the student had selected
		////then allot the seat to the student
		////and take of other things
		//else
		////place the applicant in the pending lot
		//remove the applicant from the currently processing lot

		//else increment iteration empty contents of pending lot to current lot

		//as of 28th February most of the above mentioned things is invalid

		//the 50 % of the seats is reserved for girls

		$iteration = 1;
		$cnt = true;
		$pending_lot = [];

		$applicationCycle = \Models\ApplicationCycle::where('state_id', $state_id)
			->where('status', 'new')
			->orderBy('updated_at')
			->first();

		if (count($applicationCycle) > 0) {

			if ($type == 'manual') {
				$applicationCycle->trigger_type = $type;
			}

			$applicationCycle->status = 'completed';
			$applicationCycle->save();
		}

		$current_lot = \Models\RegistrationBasicDetail::where('state_id', $state_id)
			->with(['registration_cycle'])
			->whereHas('registration_cycle', function ($query) use ($applicationCycle) {
				$query->where('application_cycle_id', $applicationCycle->id)
					->where('status', 'applied');
			})
			->get()
			->toArray();

		$applicants = $current_lot;

		while ($iteration < 4 && $cnt == true) {

			while (count($current_lot) > 0) {

				$selected = rand(0, count($current_lot) - 1);

				if (sizeof($current_lot[$selected]['registration_cycle']['preferences']) >= $iteration) {

					$school_id = $current_lot[$selected]['registration_cycle']['preferences'][$iteration - 1];

					$totalSeats = \Models\SchoolLevelInfo::where('school_id', $school_id)
						->where('level_id', $current_lot[$selected]['level_id'])
						->where('session_year', $applicationCycle->session_year)
						->first();

					$allotedSeats = \Models\AllottmentStatistic::where('school_id', $school_id)
						->where('level_id', $current_lot[$selected]['level_id'])
						->where('year', $applicationCycle->session_year)
						->first();

					if (empty($allotedSeats) && !empty($totalSeats)) {
						$allotedSeats = new \Models\AllottmentStatistic();

						$allotedSeats->school_id = $school_id;
						$allotedSeats->level_id = $current_lot[$selected]['level_id'];
						$allotedSeats->year = $applicationCycle->session_year;
						$allotedSeats->save();

					}

					if (!empty($totalSeats)) {
						if (($totalSeats->total_seats - $allotedSeats->allotted_seats) > 0) {
							$allotedSeats->allotted_seats = $allotedSeats->allotted_seats + 1;
							$allotedSeats->save();

							\Models\RegistrationCycle::where('registration_id', $current_lot[$selected]['id'])
								->update(['status' => 'allotted', 'allotted_school_id' => $school_id]);

						} else {
							$allotedSeats->full_house = true;
							$allotedSeats->save();

							array_push($pending_lot, $current_lot[$selected]);
						}
					} else {

						array_push($pending_lot, $current_lot[$selected]);
					}
				}

				array_splice($current_lot, $selected, 1);

			}

			if (count($pending_lot) > 0) {

				$current_lot = $pending_lot;
				$pending_lot = [];

				$iteration = $iteration + 1;
			} else {

				$cnt = false;
			}
		}

		foreach ($applicants as $key => $applicant) {

			if (isset($applicant['email']) && !empty($applicant['email'])) {

				$EmailData = array(
					'registration_no' => $applicant['registration_no'],
					'first_name' => $applicant['first_name'],
					'middle_name' => $applicant['middle_name'],
					'last_name' => $applicant['last_name'],

				);

				$subject = 'RTE Lottery Result Annoucement';

				\MailHelper::sendSyncMail('state::emails.student-lottery-result', $subject, $applicant['email'], $EmailData);
			}

			$input['phone'] = $applicant['mobile'];
			$input['message'] = "RTE lottery results are out. check out application status by clicking on Student Results. - PE Indus Action";

			\MsgHelper::sendSyncSMS($input);
		}

	}

}