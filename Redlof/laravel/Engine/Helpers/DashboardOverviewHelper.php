<?php
namespace Helpers;
use Models\RegistrationCycle;
use Models\School;
use Models\SchoolNodal;
use Models\UdiseNodal;

class DashboardOverviewHelper {

	public static function applyOveriewFilter($state_id, $data) {

		$filtered_data = [];

		$filtered_data['school_registration_percentage'] = self::getSchoolRegistrationPercentage($state_id, $data);
		// return ($filtered_data);

		$filtered_data['school_registration'] = [];

		if ($filtered_data['school_registration_percentage']['show']) {
			$filtered_data['school_registration'] = array(
				array('label' => 'Registered Schools',
					'value' => $filtered_data['school_registration_percentage']['registered_schools']),
				array('label' => 'Unregistered Schools',
					'value' => $filtered_data['school_registration_percentage']['total_schools']),
			);

		}

		$filtered_data['school_participation_percentage'] = self::getSchoolParticipationPercentage($state_id, $data);

		$filtered_data['school_participation'] = [];

		if ($filtered_data['school_participation_percentage']['show']) {
			$filtered_data['school_participation'] = array(
				array('label' => 'Schools with atleast one admission',
					'value' => $filtered_data['school_participation_percentage']['schools_with_atleast_one_admission']),
				array('label' => 'Schools with no admission',
					'value' => $filtered_data['school_participation_percentage']['schools_with_no_admission']),
			);

		}

		// $filtered_data['top_districts'] = self::getTopPerformingDistricts($state_id, $data);
		// $filtered_data['top_nodals'] = self::getTopPerformingNodals($state_id, $data);

		return $filtered_data;

	}

	public static function getTopPerformingDistricts($state_id, $data) {

		$schools = School::select('id', 'district_id')
			->where('state_id', $state_id)
			->where('application_status', 'verified')
			->get();

		$students = \Models\RegistrationBasicDetail::select('id')
			->where('status', 'completed')
			->where('state_id', $state_id);

		if ($data['selectedDistrict'] != 'null') {

			$students->whereHas('personal_details', function ($query) use ($data) {

				$query->where('district_id', $data['selectedDistrict']);
			});

		}

		if ($data['selectedCycle'] != 'null') {

			$students->whereHas('registration_cycle.application_details', function ($query) use ($data) {

				$query->where('session_year', $data['selectedCycle']);
			});

		}

		$students_with_reg_cycle = $students->with('registration_cycle')->get();

		$schools_by_district = $schools->groupBy('district_id');

		$all_districts = \Models\District::select('id', 'name')
			->where('status', 'active')->get();

		$ranking = [];

		foreach ($schools_by_district as $district_id => $schools_in_district) {
			$application_count = 0;
			$enrollment_count = 0;

			foreach ($students_with_reg_cycle as $student) {
				if (!empty($student->registration_cycle->preferences)) {
					$check_presence = array_intersect($student->registration_cycle->preferences, $schools_in_district->pluck('id')->all());
					if (count($check_presence) > 0) {
						$application_count++;
						if ($student->registration_cycle->status == 'enrolled') {
							$enrollment_count++;
						}
					}

				} elseif (!empty($student->registration_cycle->nearby_preferences)) {
					$check_presence = array_intersect($student->registration_cycle->nearby_preferences, $schools_in_district->pluck('id')->all());
					if (count($check_presence) > 0) {
						$application_count++;
						if ($student->registration_cycle->status == 'enrolled') {
							$enrollment_count++;
						}
					}

				}
			}
			$perc = 0;
			$enroll_application_percentage = 0;
			if ($application_count > 0) {

				$enroll_application_percentage = round($enrollment_count * 100 / $application_count, 1);
			}

			$ranking[$district_id] = array(
				// 'application_count' => $application_count,
				// 'enrollment_count' => $enrollment_count,
				'enroll_application_percentage' => $enroll_application_percentage,
				'district_name' => $all_districts->where('id', $district_id)->first()->name,
			);
		}
		usort($ranking, function ($a, $b) {
			return $b['enroll_application_percentage'] > $a['enroll_application_percentage'];
		});
		$i = 0;
		$district_chart = [];
		foreach ($ranking as $key => $single_district) {
			$district_chart[] = array(
				'label' => $single_district['district_name'],
				'value' => $single_district['enroll_application_percentage'],
				// 'application_count' => $single_district['application_count'],
				// 'enrollment_count' => $single_district['enrollment_count'],
			);
			$i++;
			if ($i == 3) {
				break;
			}

		}

		return $district_chart;

	}

	public static function getTopPerformingNodals($state_id, $data) {

		if ($data['selectedDistrict'] != "null") {

			$nodal = \Models\StateNodal::select('id', 'user_id')
				->where('state_id', $state_id)
				->where('status', 'active')
				->where('district_id', $data['selectedDistrict'])
				->with('user')
				->get();

		} else {

			$nodal = \Models\StateNodal::select('id', 'user_id')
				->where('state_id', $state_id)
				->where('status', 'active')
				->with('user')
				->get();

		}

		$school_nodals = SchoolNodal::select('id', 'school_id', 'nodal_id')
			->whereIn('nodal_id', $nodal->pluck('id')->all())
			->get();

		$students = \Models\RegistrationBasicDetail::select('id')
			->where('status', 'completed')
			->where('state_id', $state_id);

		if ($data['selectedDistrict'] != 'null') {

			$students->whereHas('personal_details', function ($query) use ($data) {

				$query->where('district_id', $data['selectedDistrict']);
			});

		}

		if ($data['selectedCycle'] != 'null') {

			$students->whereHas('registration_cycle.application_details', function ($query) use ($data) {

				$query->where('session_year', $data['selectedCycle']);
			});

		}

		$students_with_reg_cycle = $students->with('registration_cycle')->get();

		$schools_by_nodal = $school_nodals->groupBy('nodal_id');

		// $all_districts = \Models\District::where('status', 'active')->get();

		$ranking = [];

		foreach ($schools_by_nodal as $nodal_id => $schools_in_nodal) {
			$application_count = 0;
			$enrollment_count = 0;
			foreach ($students_with_reg_cycle as $student) {
				if (!empty($student->registration_cycle->preferences)) {
					$check_presence = array_intersect($student->registration_cycle->preferences, $schools_in_nodal->pluck('school_id')->all());
					if (count($check_presence) > 0) {
						$application_count++;
						if ($student->registration_cycle->status == 'enrolled') {
							$enrollment_count++;
						}
					}

				} elseif (!empty($student->registration_cycle->nearby_preferences)) {
					$check_presence = array_intersect($student->registration_cycle->nearby_preferences, $schools_in_nodal->pluck('school_id')->all());
					if (count($check_presence) > 0) {
						$application_count++;
						if ($student->registration_cycle->status == 'enrolled') {
							$enrollment_count++;
						}
					}

				}
			}
			$perc = 0;
			$enroll_application_percentage = 0;
			if ($application_count > 0) {

				$enroll_application_percentage = round($enrollment_count * 100 / $application_count, 1);
			}

			$ranking[$nodal_id] = array(
				// 'application_count' => $application_count,
				// 'enrollment_count' => $enrollment_count,
				'enroll_application_percentage' => $enroll_application_percentage,
				'nodal_name' => $nodal->where('id', $nodal_id)->first()->user->first_name,
			);
		}
		// asort($ranking);
		usort($ranking, function ($a, $b) {
			return $b['enroll_application_percentage'] > $a['enroll_application_percentage'];
		});
		$i = 0;
		$nodal_chart = [];
		foreach ($ranking as $key => $single_nodal) {
			$nodal_chart[] = array(
				'label' => $single_nodal['nodal_name'],
				'value' => $single_nodal['enroll_application_percentage'],
				// 'application_count' => $single_nodal['application_count'],
				// 'enrollment_count' => $single_nodal['enrollment_count'],
			);
			$i++;
			if ($i == 3) {
				break;
			}

		}

		return $nodal_chart;

	}

	public static function getTopPerformingSchools($state_id, $data) {

		$school_nodals = \Models\SchoolNodal::select('id', 'school_id')
			->where('nodal_id', $data['selectedNodal'])
			->get();

		// $application_cycles = \Models\ApplicationCycle::select('id', 'state_id')
		// 	->where('state_id', $state_id)
		// 	->where('status', 'completed');

		// if ($data['selectedCycle'] != 'null') {
		// 	$application_cycles->where('session_year', $data['selectedCycle']);

		// }

		// $registration_cycle = \Models\RegistrationCycle::whereIn('application_cycle_id', $application_cycles->pluck('id')->all())
		// 	->get();

		$students = \Models\RegistrationBasicDetail::select('id')
			->where('status', 'completed')
			->where('state_id', $state_id);

		if ($data['selectedDistrict'] != 'null') {

			$students->whereHas('personal_details', function ($query) use ($data) {

				$query->where('district_id', $data['selectedDistrict']);
			});

		}

		if ($data['selectedCycle'] != 'null') {

			$students->whereHas('registration_cycle.application_details', function ($query) use ($data) {

				$query->where('session_year', $data['selectedCycle']);
			});

		}

		$students_with_reg_cycle = $students->with('registration_cycle')->get();

		// $schools_by_id = $school_nodals->groupBy('school_id');

		$schools = \Models\School::select('id', 'name')
			->whereIn('id', $school_nodals->pluck('school_id')->all())->get();

		$ranking = [];

		foreach ($schools as $key => $single_school) {
			$application_count = 0;
			$enrollment_count = 0;
			$school_id = $single_school['id'];
			foreach ($students_with_reg_cycle as $student) {
				if (!empty($student->registration_cycle->preferences) && in_array($school_id, $student->registration_cycle->preferences)) {
					$application_count++;
					if ($student->registration_cycle->status == 'enrolled' && $student->registration_cycle->allotted_school_id == $school_id) {
						$enrollment_count++;
					}
				} elseif (!empty($student->registration_cycle->nearby_preferences) && in_array($school_id, $student->registration_cycle->nearby_preferences)) {
					$application_count++;
					if ($student->registration_cycle->status == 'enrolled' && $student->registration_cycle->allotted_school_id == $school_id) {
						$enrollment_count++;
					}
				}
			}

			// $enrollment_count += $registration_cycle->where('allotted_school_id', $school_id)->where('status', 'enrolled')->count();

			$perc = 0;
			$enroll_application_percentage = 0;
			if ($application_count > 0) {

				$enroll_application_percentage = round($enrollment_count * 100 / $application_count, 1);
			}

			$school_name = $schools->where('id', $school_id)->first()->name;
			$splitted_school = explode(' ', $school_name);
			$trimmed_school_name = '';

			if (count($splitted_school) >= 3) {
				$trimmed_school_name = $splitted_school[0] . ' ' . $splitted_school[1] . ' ' . $splitted_school[2];
			} else {
				$trimmed_school_name = $school_name;
			}

			$ranking[$school_id] = array(
				// 'application_count' => $application_count,
				// 'enrollment_count' => $enrollment_count,
				'enroll_application_percentage' => $enroll_application_percentage,
				'school_name' => $trimmed_school_name,
			);
		}
		// asort($ranking);
		usort($ranking, function ($a, $b) {
			return $b['enroll_application_percentage'] > $a['enroll_application_percentage'];
		});
		$i = 0;
		$school_chart = [];
		foreach ($ranking as $key => $single_school) {
			$school_chart[] = array(
				'label' => $single_school['school_name'],
				'value' => $single_school['enroll_application_percentage'],
				// 'application_count' => $single_school['application_count'],
				// 'enrollment_count' => $single_school['enrollment_count'],
			);
			$i++;
			if ($i == 3) {
				break;
			}

		}

		return $school_chart;

	}

	public static function getSchoolRegistrationPercentage($state_id, $data) {

		$schools = School::select('id', 'district_id', 'created_at', 'levels', 'application_status', 'udise')
			->where('state_id', $state_id);

		if ($data['selectedDistrict'] != 'null') {

			$schools->where('district_id', $data['selectedDistrict']);

		}

		if ($data['selectedCycle'] != 'null') {

			$schools->whereYear('created_at', $data['selectedCycle']);

		}

		if ($data['selectedNodal'] != 'null') {

			$nodal_school_ids = SchoolNodal::where('nodal_id', $data['selectedNodal'])->get()->pluck('school_id');

			$schools->whereIn('id', $nodal_school_ids);

		}

		if ($data['selectedClass'] != 'null') {

			$schools->where('levels', '["' . $data['selectedClass'] . '"]');

		}

		$schools = $schools->get();

		$unverified_schools = 0;
		$all_schools = 0;

		foreach ($schools as $key => $school) {

			if ($school->application_status != 'verified') {

				$unverified_schools += 1;
			}
		}

		$registered_schools = 0;

		foreach ($schools as $key => $school) {

			if ($school->application_status == 'verified') {

				$registered_schools += 1;
			}
		}

		$existing_udise = $schools->pluck('udise');

		$uploaded_udise = UdiseNodal::whereNotIn('udise', $existing_udise)->count();

		$all_schools = $unverified_schools + $uploaded_udise;

		// $total_schools = $registered_schools + $all_schools;

		$total_schools = $schools->count();

		// $unregistered_schools = $all_schools - $registered_schools;

		$unregistered_schools = $total_schools - $registered_schools;

		$school_data = [];

		if ($total_schools > 0) {
			$school_data['show'] = true;

			$school_data['registered_schools'] = $registered_schools;

			// $school_data['total_schools'] = $all_schools;

			$school_data['total_schools'] = $unregistered_schools;

			$school_data['registered_schools_percentage'] = round(($registered_schools * 100) / $total_schools, 1);

			// $school_data['total_schools_percentage'] = round(($all_schools * 100) / $total_schools, 1);

			$school_data['total_schools_percentage'] = round(($unregistered_schools * 100) / $total_schools, 1);

		} else {
			$school_data['show'] = false;

		}

		return $school_data;

	}

	public static function getSchoolParticipationPercentage($state_id, $data) {

		$schools = School::select('id', 'district_id', 'created_at', 'levels', 'application_status', 'udise')
			->where('state_id', $state_id)
			->where('application_status', 'verified');

		if ($data['selectedDistrict'] != 'null') {

			$schools->where('district_id', $data['selectedDistrict']);

		}

		if ($data['selectedCycle'] != 'null') {

			$schools->whereYear('created_at', $data['selectedCycle']);

		}

		if ($data['selectedClass'] != 'null') {

			$schools->where('levels', '["' . $data['selectedClass'] . '"]');

		}
		if ($data['selectedNodal'] != 'null') {

			$nodal_school_ids = SchoolNodal::select('id', 'school_id')
				->where('nodal_id', $data['selectedNodal'])->get()->pluck('school_id');

			$schools->whereIn('id', $nodal_school_ids);

		}

		$registered_schools = $schools->get();

		$enrolled_schools = RegistrationCycle::select('id', 'allotted_school_id')
			->where('status', 'enrolled')
			->whereIn('allotted_school_id', $registered_schools->pluck('id'))
			->get();

		$unique_schools = array_unique($enrolled_schools->pluck('allotted_school_id')->toArray());

		$school_data = [];
		if (count($registered_schools) > 0) {
			$school_data['schools_with_atleast_one_admission'] = count($unique_schools);

			$school_data['schools_with_no_admission'] = count($registered_schools) - count($unique_schools);

			$school_data['schools_with_atleast_one_admission_percentage'] = round(($school_data['schools_with_atleast_one_admission'] * 100) / count($registered_schools), 1);

			$school_data['schools_with_no_admission_percentage'] = round(($school_data['schools_with_no_admission'] * 100) / count($registered_schools), 1);

			$school_data['show'] = true;
		}

		if (count($registered_schools) == 0) {
			$school_data['show'] = false;

		}

		return $school_data;

	}

}