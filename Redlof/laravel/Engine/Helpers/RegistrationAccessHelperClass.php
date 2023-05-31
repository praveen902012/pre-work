<?php
namespace Helpers;

class RegistrationAccessHelperClass {

	static function checkAccess($registration, $step, $state) {

		$return_value = false;

		if (empty($registration)) {
			throw new \Exceptions\UnAuthorizedException("Invalid registration number");
		}

		if ($registration->registration_cycle) {

			if ($registration->registration_cycle->cycle == 1) {

				if ($registration->registration_cycle->status == 'allotted') {

					throw new \Exceptions\UnAuthorizedException("You are enrollment process is incomplete");

				} elseif ($registration->registration_cycle->status == 'enrolled') {

					throw new \Exceptions\UnAuthorizedException("You have been already enrolled to the school.");

				}

				$registrations = self::checkRegistrationCompletion($registration->id);

				if ($registrations > 1) {

					if ($registration->status == 'completed') {

						throw new \Exceptions\UnAuthorizedException("Your registraton is already complete, you can now check your registration status");

					}

				}

			} elseif ($registration->registration_cycle->status == 'applied' && $registration->registration_cycle->cycle != 1 && $registration->status == 'completed') {

				throw new \Exceptions\UnAuthorizedException("Your registraton is already complete, you can now check your registration status");

			}

		} else {

			if ($registration->status == 'completed') {

				if ($state->application_cycle->cycle > 1 && intval($step[4]) == 5) {

					if ($registration->registration_cycle->status == 'not_reported') {

						return $return_value;
					}

				}

				throw new \Exceptions\UnAuthorizedException("Your registraton is already complete, you can now check your registration status");
			}
		}

		if (intval($registration->state[4]) < intval($step[4])) {
			throw new \Exceptions\UnAuthorizedException("Please complete previous steps in order to view this page");
		}

		return $return_value;
	}

	static function checkAccessSansException($registration, $step) {

		$return_value = 'disabled';

		if (intval($registration->state[4]) >= intval($step[4])) {
			$return_value = false;
		}

		$applicationCycle = \Models\ApplicationCycle::select('id', 'cycle', 'session_year')
			->where('state_id', $registration->state_id)
			->where('status', 'new')
			->where('cycle', '>', 1)
			->orderBy('updated_at')
			->first();

		return $return_value;
	}

	static public function cycleCheck($state) {

		if (!$state->student_registration) {
			throw new \Exceptions\UnAuthorizedException("Registrations have not began yet");
		}
	}

	static public function checkRegistrationCompletion($registration_id) {

		$check = \Models\RegistrationCycle::where('registration_id', $registration_id)->count();

		return $check;
	}

}