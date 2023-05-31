<?php
namespace Redlof\Core\Helpers;
/**
 * API Helper class
 */
class DateHelper {

	function __construct() {}

	public static function formatDate($Date, $format = "jS M Y") {
		$carbon = new \Carbon\Carbon($Date);
		$formatteddate = $carbon->format($format);

		return $formatteddate;
	}

	public static function displayAgoEquivalentOfDate($date) {
		$carbon = new \Carbon\Carbon($date);
		return $carbon->diffForHumans();
	}

	public static function displayDateDiffByMonth($start_date, $end_date) {
		$s_date = new \Carbon\Carbon($start_date);
		$e_date = new \Carbon\Carbon($end_date);
		return $s_date->diffForHumans($e_date, true);
	}

}