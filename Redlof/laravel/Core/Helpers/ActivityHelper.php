<?php
namespace Redlof\Core\Helpers;

use Models\Activity;
use Models\ActivityLog;

/**
 * Actitvity Helper class
 */
class ActivityHelper {

	protected $activitylog;

	function __construct() {

	}

	public static function record($member, $activity_name, $resource = null) {

		// find the id from database
		$activity_details = Activity::where('name', $activity_name)->first();

		if (!$activity_details) {
			return false;
		}

		// make an entry
		$activitylogObj = new ActivityLog();

		$activitylogObj->activity_id = $activity_details['id'];
		$activitylogObj->user_id = $member->id;
		$activitylogObj->resource = isset($resource) ? $resource : '';

		// $activitylogObj->resource = json_encode($activitylogObj->resource);

		return $activitylogObj->save();
	}
}