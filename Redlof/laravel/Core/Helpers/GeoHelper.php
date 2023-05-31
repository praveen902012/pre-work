<?php
namespace Redlof\Core\Helpers;

class GeoHelper {

	function __construct() {}

	public static function validateLat($lat) {
		$latreg = '/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/';
		if (preg_match($latreg, trim($lat))) {
			return true;
		} else {
			return false;
		}
	}

	public static function validateLng($lng) {
		$lngreg = '/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/';

		if (preg_match($lngreg, trim($lng))) {
			return true;
		} else {
			return false;
		}
	}

	// $earthRadious = 3959(miles) ----- $earthRadious = 6371000(meter)
	public static function getDistanceBetweenCoordinates($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 3959) {

		// convert from degrees to radians
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$lonDelta = $lonTo - $lonFrom;

		$a = pow(cos($latTo) * sin($lonDelta), 2) + pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		$b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

		$angle = atan2(sqrt($a), $b);
		return $angle * $earthRadius;
	}

}