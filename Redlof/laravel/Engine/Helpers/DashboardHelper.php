<?php
namespace Helpers;

class DashboardHelper {

	public static function getSchoolInfo($state_id, $application_cycle_year, $district_id, $nodal_id) {

		$application_cycles = \Models\ApplicationCycle::select('id', 'state_id')
			->where('state_id', $state_id)
			->where('status', 'completed');

		$udise_nodals = \Models\UdiseNodal::select('id', 'udise', 'district_id');

		$schools = \Models\School::select('id', 'udise', 'created_at', 'district_id')
			->where('state_id', $state_id)
			->where('status', 'active')
			->where('application_status', 'verified');

		$school_nodals = \Models\SchoolNodal::select('id', 'school_id', 'nodal_id');

		if ($application_cycle_year != 'null') {

			$schoolIds = \Models\SchoolCycle::whereHas('application_cycle', function ($query) use ($application_cycle_year) {

				$query->where('session_year', $application_cycle_year);
			})->pluck('school_id');

			$schools->whereIn('id', $schoolIds);
			$application_cycles->where('session_year', $application_cycle_year);
		}

		if ($district_id != 'null') {
			
			$schools->where('district_id', $district_id);

			$udise_nodals->where('district_id', $district_id);
		}

		if ($district_id == 'null') {

			$district = \Models\District::select('id')
				->where('state_id', $state_id)
				->select('id', 'name')
				->where('status', 'active')
				->get();

			$schools->whereIn('district_id', $district->pluck('id')->all());
			
			$udise_nodals->whereIn('district_id', $district->pluck('id')->all());
		}

		if ($nodal_id != 'null') {
			
			$school_nodals->where('nodal_id', $nodal_id);

			$schools->whereIn('id', $school_nodals->pluck('school_id')->all());
		}

		if ($nodal_id == 'null') {

			if ($district_id != "null") {

				$nodal = \Models\StateNodal::select('id')
					->where('state_id', $state_id)
					->where('status', 'active')
					->where('district_id', $district_id)
					->get();

			} else {

				$nodal = \Models\StateNodal::select('id')
					->where('state_id', $state_id)
					->where('status', 'active')
					->get();
				
			}
				
			$school_nodals->whereIn('nodal_id', $nodal->pluck('id')->all());
		}

		$schools = $schools->get();

		$school_nodals = $school_nodals->get();
		
		$udise_nodals = $udise_nodals->get();

		// 1st metric

		$total_schools_udise = $schools->whereIn('udise', $udise_nodals->pluck('udise')->unique()->all())
								->whereIn('id', $school_nodals->pluck('school_id')->all());

		// 2nd metric

		$verified_schools = $schools->whereIn('id', $school_nodals->pluck('school_id')->all());

		// get registered school
		$application_cyc = \Models\ApplicationCycle::where('session_year', $application_cycle_year)
			->get();

		$schoolIds = \Models\SchoolCycle::whereIn('application_cycle_id', $application_cyc->pluck('id')->toarray())
			->pluck('school_id');
				
		if($nodal_id != 'null') {
			
			$registered_schools = \Models\School::whereIn('id', $schoolIds)
				->where('state_id', $state_id)
				->whereIn('id', $school_nodals->pluck('school_id')->all());
			
		}elseif($district_id != 'null'){

			$registered_schools = \Models\School::whereIn('id', $schoolIds)
				->where('state_id', $state_id)
				->where('district_id', $district_id);

		}else{

			$registered_schools = \Models\School::whereIn('id', $schoolIds)
				->where('state_id', $state_id);
		}

		$students = \Models\RegistrationBasicDetail::select('id')
			->where('status', 'completed')
			->where('state_id', $state_id);

		if ($district_id != 'null') {

			$students->whereHas('personal_details', function ($query) use ($district_id) {

				$query->where('district_id', $district_id);
			});
		}

		if ($application_cycle_year != 'null') {

			$students->whereHas('registration_cycle.application_details', function ($query) use ($application_cycle_year) {

				$query->where('session_year', $application_cycle_year);
			});
		}

		$students_with_reg_cycle = $students->with('registration_cycle')->get();

		$registration_cycle = \Models\RegistrationCycle::select('id', 'status', 'meta_data')
			->whereIn('application_cycle_id', $application_cycles->pluck('id')->all())
			->get();

		$reg_schools_count = $registered_schools->count();

		$registered_schools_ids = $registered_schools->where('application_status', '!=' ,'applied')->pluck('id')->all();

		$one_student_enrolled = $students_with_reg_cycle->where('registration_cycle.status', 'enrolled')
			->whereIn('registration_cycle.allotted_school_id', $registered_schools_ids)
			->pluck('registration_cycle.allotted_school_id')
			->all();

		// 3rd metric
		$one_student_enrolled = array_unique($one_student_enrolled);

		$preferences = $students_with_reg_cycle->pluck('registration_cycle.preferences');
		
		$nearby_preferences = $students_with_reg_cycle->pluck('registration_cycle.nearby_preferences');
		
		$schools_filled_in = [];

		foreach ($preferences as $key => $preference) {

			if ($preference != null) {
			
				foreach ($preference as $key => $school_id) {
			
					if (in_array($school_id, $registered_schools_ids)) {
						$schools_filled_in[] = $school_id;
					}
				}
			}
		}

		foreach ($nearby_preferences as $key => $preference) {

			if ($preference != null) {

				foreach ($preference as $key => $school_id) {

					if (in_array($school_id, $registered_schools_ids)) {

						$schools_filled_in_1[] = $school_id;
					}
				}
			}
		}

		$all_school_ids = $schools->pluck('id')->all();

		// 4th metric

		$schools_filled_in = array_unique($schools_filled_in);

		$schools_with_no_application = array_diff($registered_schools_ids, $schools_filled_in);

		// 5th metric

		$schools_with_no_enrollment = array_diff($registered_schools_ids, $schools_with_no_application, $one_student_enrolled);

		// 6th metric
		// get all schools
		// foreach school get the number of applications and the number of applicant enrolled
		// append the school_id in one of the percentage group

		$school_admission_application_distribution = [
			'below_25' => array(),
			'range_25_50' => array(),
			'range_50_75' => array(),
			'range_75_100' => array(),
		];

		$school_admission_application_count = [
			'below_25' => 0,
			'range_25_50' => 0,
			'range_50_75' => 0,
			'range_75_100' => 0,
		];

		foreach ($all_school_ids as $school_id) {

			$application_count = 0;
			
			foreach ($students_with_reg_cycle as $item) {

				if (!empty($item->registration_cycle->preferences) && in_array($school_id, $item->registration_cycle->preferences)) {
					$application_count++;
				} elseif (!empty($item->registration_cycle->nearby_preferences) && in_array($school_id, $item->registration_cycle->nearby_preferences)) {
					$application_count++;
				}
			}

			$any_enrollment = $students_with_reg_cycle->where('registration_cycle.allotted_school_id', $school_id)->where('registration_cycle.status', 'enrolled')->count();
			
			if ($application_count == 0) {
				$admission_application_perc = 0;
			} else {

				$admission_application_perc = round(($any_enrollment / $application_count) * 100);
			}

			// $school_admission_application_distribution[$school_id] = array($application_count, $any_enrollment, $admission_application_perc);
			if ($admission_application_perc < 25) {
				// $school_admission_application_distribution['below_25'][] = $school_id;
				$school_admission_application_count['below_25'] += 1;
			} elseif ($admission_application_perc >= 25 && $admission_application_perc < 50) {
				// $school_admission_application_distribution['range_25_50'][] = $school_id;
				$school_admission_application_count['range_25_50'] += 1;
			} elseif ($admission_application_perc >= 50 && $admission_application_perc < 75) {
				// $school_admission_application_distribution['range_50_75'][] = $school_id;
				$school_admission_application_count['range_50_75'] += 1;
			} elseif ($admission_application_perc >= 75 && $admission_application_perc <= 100) {
				// $school_admission_application_distribution['range_75_100'][] = $school_id;
				$school_admission_application_count['range_75_100'] += 1;
			}

		}

		$reason_count = array(
			'did_not_report' => 0,
			'no_document' => 0,
			'false_document' => 0,
		);

		// $rejection_reason = $students_with_reg_cycle->where('registration_cycle.status', 'rejected')->pluck('registration_cycle.meta_data');

		$rejection_reason = $registration_cycle->where('status', 'rejected')
			->pluck('meta_data')
			->all();

		foreach ($rejection_reason as $key => $value) {

			if (!empty($value['reason']) && $value['reason'] != null) {

				if ($value['reason'] == 'Did not report') {
					$reason_count['did_not_report'] += 1;

				} elseif ($value['reason'] == 'No document') {
					$reason_count['no_document'] += 1;

				} elseif ($value['reason'] == 'False document') {
					$reason_count['false_document'] += 1;

				}
			}
		}

		arsort($reason_count);

		// 7th metric
		$reason_perc = [];

		$show_reason = true;
		
		$total_rejection = count($rejection_reason);
		
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

		return (
			array(
				'total_schools_udise' => $total_schools_udise->count(),
				'verified_schools' => $verified_schools->count(),
				'registered_schools' => $reg_schools_count,
				'one_student_enrolled' => count($one_student_enrolled),
				'schools_with_no_application' => count($schools_with_no_application),
				'schools_with_no_enrollment' => count($schools_with_no_enrollment),
				// 'school_admission_application_distribution' => $school_admission_application_distribution,
				'school_admission_application_distribution' => $school_admission_application_count,
				'show_reason' => $show_reason,
				'reason_perc' => $reason_perc,
				'rejection_graph' => $rejection_graph)
		);
	}

}