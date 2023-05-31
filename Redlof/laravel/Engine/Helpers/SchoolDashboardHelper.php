<?php
namespace Helpers;
use Models\RegistrationCycle;
use Models\SchoolLevelInfo;

class SchoolDashboardHelper {

	public static function getDashboardStatistics($school, $data) {

		$filtered_data = [];

		$registrations = RegistrationCycle::with('basic_details', 'application_details');

		if ($data['selectedCycle'] != 'null') {

			$registrations->whereHas('application_details', function ($query) use ($data) {

				$query->where('session_year', $data['selectedCycle']);
			});
		}

		if ($data['selectedSex'] != 'null') {

			$registrations->whereHas('basic_details', function ($query) use ($data) {

				$query->where('gender', $data['selectedSex']);;
			});
		}

		if ($data['selectedCategory'] != 'null') {

			$registrations->whereHas('basic_details.personal_details', function ($query) use ($data) {

				$query->where('category', 'dg')
					->whereRaw("certificate_details->>'dg_type' = '" . $data['selectedCategory'] . "'");
			});
		}

		$registrations = $registrations->get();

		$filtered_data['total_unique_applications'] = self::getUniqueApplications($school->id, $data, $registrations);

		$filtered_data['nearby_preferences'] = self::getNearbyPreferencesStatistics($school->id, $data, $registrations);

		$filtered_data['neighboring_preferences'] = self::getNeighboringPreferencesStatistics($school->id, $data, $registrations);

		$filtered_data['total_seats'] = self::getTotalSeats($school->id, $school->levels);

		$filtered_data['total_admissions'] = self::getTotalAdmissions($school->id, $data, $registrations);

		$filtered_data['percentage_of_fill_rate'] = self::getFillRatePercentage($school->id, $data, $registrations, $filtered_data['total_unique_applications']);

		$filtered_data['graph_fill_rate'] = [];

		if ($filtered_data['percentage_of_fill_rate']['show']) {
			$filtered_data['graph_fill_rate'] = array(
				array('label' => 'Enrolled',
					'value' => $filtered_data['percentage_of_fill_rate']['fill_percentage']),
				array('label' => 'Not enrolled',
					'value' => $filtered_data['percentage_of_fill_rate']['unfill_percentage']),
			);
		}

		$temp = self::getTopReasonsForProvisionalAdmission($school->id, $data, $registrations);

		$filtered_data['show_reason'] = $temp[0];
		$filtered_data['top_reasons_for_provisional_admission'] = $temp[1];
		$filtered_data['rejection_graph'] = $temp[2];

		return $filtered_data;
	}

	public static function getUniqueApplications($school_id, $data, $registrations) {

		$applications = 0;

		foreach ($registrations as $key => $registration) {

			if ($registration->preferences != null) {
				foreach ($registration->preferences as $key => $preference) {

					if ($preference == $school_id) {

						$applications += 1;
					}

				}
			}

			if ($registration->nearby_preferences != null) {

				foreach ($registration->nearby_preferences as $key => $preference) {

					if ($preference == $school_id) {

						$applications += 1;
					}

				}
			}

		}

		return $applications;

	}

	public static function getNearbyPreferencesStatistics($school_id, $data, $registrations) {

		$statistics = [];

		foreach ($registrations as $key => $registration) {

			if ($registration->preferences != null) {

				$stat = [];

				$stat['applications'] = 0;

				foreach ($registration->preferences as $keypref => $preference) {

					if ($preference == $school_id) {

						$stat['pos'] = $keypref + 1;

						$stat['applications'] += 1;

						array_push($statistics, $stat);
					}

				}

			}

		}

		$prev_pos = 0;

		$final_statistics = [];

		foreach ($statistics as $key => $statistic) {

			if ($prev_pos == $statistic['pos']) {

				$stat['applications'] += 1;

			} else {

				$stat = [];

				$stat['applications'] = 1;

				$stat['pos'] = $statistic['pos'];

				$prev_pos = $statistic['pos'];
			}

		}

		if (!empty($stat)) {

			array_push($final_statistics, $stat);

		}

		return $final_statistics;

	}

	public static function getNeighboringPreferencesStatistics($school_id, $data, $registrations) {

		$statistics = [];

		foreach ($registrations as $key => $registration) {

			if ($registration->nearby_preferences != null) {

				$stat = [];

				$stat['applications'] = 0;

				foreach ($registration->nearby_preferences as $keypref => $preference) {

					if ($preference == $school_id) {

						$stat['pos'] = $keypref + 1;

						$stat['applications'] += 1;

						array_push($statistics, $stat);
					}

				}

			}

		}

		$prev_pos = 0;

		$final_statistics = [];

		foreach ($statistics as $key => $statistic) {

			if ($prev_pos == $statistic['pos']) {

				$stat['applications'] += 1;

			} else {

				$stat = [];

				$stat['applications'] = 1;

				$stat['pos'] = $statistic['pos'];

				$prev_pos = $statistic['pos'];
			}

		}

		if (!empty($stat)) {

			array_push($final_statistics, $stat);

		}

		return $final_statistics;

	}

	public static function getTotalSeats($school_id, $levels) {

		$session_year = \Helpers\ApplicationCycleHelper::getLatestCycle()->session_year;
		
		$seats = SchoolLevelInfo::where('school_id', $school_id)
					->whereIn('level_id', $levels)
					->where('session_year', $session_year)
					->orderBy('created_at', 'desc')
					->pluck('available_seats')
					->first();

		return $seats;
	}

	public static function getTotalAdmissions($school_id, $data, $registrations) {

		$admissions = 0;

		foreach ($registrations as $key => $registration) {
			if ($registration->allotted_school_id != null && $registration->allotted_school_id == $school_id && $registration->status == 'enrolled') {

				$admissions += 1;

			}
		}

		return $admissions;

	}

	public static function getFillRatePercentage($school_id, $data, $registrations, $applications) {

		$fill_rate_data = [];

		$enroll_count = 0;

		foreach ($registrations as $key => $registration) {

			if ($registration->allotted_school_id == $school_id) {

				if ($registration->status == 'enrolled') {

					$enroll_count += 1;

				}

			}

		}

		$fill_rate_data['show'] = true;
		if ($applications > 0) {

			if ($enroll_count > 0) {

				$fill_percentage = ($enroll_count * 100) / $applications;

			} else {

				$fill_percentage = 0;
			}

		} else {
			$fill_rate_data['show'] = false;

			$fill_percentage = 0;

		}

		$fill_rate_data['total_applications'] = $applications;

		$fill_rate_data['total_enrollment'] = $enroll_count;

		$fill_rate_data['fill_percentage'] = $fill_percentage;
		$fill_rate_data['unfill_percentage'] = 100 - $fill_percentage;

		return $fill_rate_data;

	}

	public static function getTopReasonsForProvisionalAdmission($school_id, $data, $registrations) {

		$reason_count = array(
			'did_not_report' => 0,
			'no_document' => 0,
			'false_document' => 0,
		);

		$total_rejection = 0;

		foreach ($registrations as $key => $registration) {

			if ($registration->status == 'rejected' && $registration->allotted_school_id == $school_id) {

				$total_rejection += 1;

				if (!empty($registration->meta_data['reason']) && $registration->meta_data['reason'] != null) {
					if ($registration->meta_data['reason'] == 'Did not report') {
						$reason_count['did_not_report'] += 1;

					} elseif ($registration->meta_data['reason'] == 'No document') {
						$reason_count['no_document'] += 1;

					} elseif ($registration->meta_data['reason'] == 'False document') {
						$reason_count['false_document'] += 1;

					}
				}

			}

		}
		arsort($reason_count);

		$reason_perc = [];
		$show_reason = true;

		foreach ($reason_count as $key => $value) {
			if ($total_rejection == 0) {
				$show_reason = false;
				break;
			} else {

				$reason_perc[$key][] = array(ucwords(str_replace('_', ' ', $key)), round(($value / $total_rejection) * 100, 1));
			}

		}
		$rejection_graph = [];
		if ($show_reason) {
			$rejection_graph = array(
				array('label' => 'False Document',
					'value' => $reason_count['false_document']),
				array('label' => 'Did Not Report',
					'value' => $reason_count['did_not_report']),
				array('label' => 'No document',
					'value' => $reason_count['no_document']),
			);
		}

		return array($show_reason, $reason_perc, $rejection_graph);

	}

}