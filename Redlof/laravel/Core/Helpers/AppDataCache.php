<?php
namespace Redlof\Core\Helpers;

class AppDataCache {

	private static $data;

	public static function set($key, $value) {

		self::$data[$key] = $value;

		return self::$data[$key];

	}

	public static function get($key) {

		if (isset(self::$data[$key])) {

			return self::$data[$key];

		}

		return NULL;

	}

}