<?php
namespace Redlof\Core\Helpers;
/**
 * API Helper class
 */
class AppHelper {

	function __construct() {

	}

	public static function logoUrl() {
		return asset('img/' . config('redlof.logo'));
	}

	public static function cleanTempDir() {
		\File::cleanDirectory(public_path() . '/temp');
		\File::put(public_path() . '/temp/' . '.redlof', '', true);
	}

	public static function cleanTempFile($file_name) {
		\File::delete(public_path() . '/temp/' . $file_name);
	}

	public static function cleanTempFileDir($file_name) {
		\File::deleteDirectory(public_path() . '/temp/' . $file_name);
	}

	public static function getConstants() {
		// Set an array which has project specific constants set as
		// key value pairs and return in json format

		$c = array();

		$c['name'] = config('redlof.name');
		$c['logo'] = config('redlof.logo');
		$c['env'] = config('app.env');
		$c['debug'] = config('app.debug');
		$c['url'] = url("/");
		$c['api_url'] = url('/') . '/api/';

		$c['title'] = config('redlof.name');
		$c['GoogleAppKey'] = config('redlof.GOOGLE_APP_KEY');
		$c['FBAppKey'] = config('redlof.FB_APP_KEY');
		$c['PusherAppKey'] = config('redlof.PUSHER_APP_KEY', '2726a871c35152c28475');

		return $c;
	}

	public static function isActive($routeTags, $output = "is-active") {

		$RetVal = '';

		foreach ($routeTags as $tag) {

			if (\Request::is('*' . $tag . '*')) {
				$RetVal = $output;
				break;
			}
		}

		return $RetVal;
	}

}