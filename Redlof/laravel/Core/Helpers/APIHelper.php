<?php
namespace Redlof\Core\Helpers;
/**
 * API Helper class
 */
class APIHelper {

	function __construct() {

	}

	/**
	 * This function will transform the collection of data
	 * @param [array] $[items] [This is array data where we want to perform transform]
	 * @param [array] $[args] [(optional) It will take fields which all we want to remove from the array ex 'created_at' otherwise by default it will remove 'created_at, deleted_at, updated_at' fields from array]
	 * @uses [\APIHelper::transformCollection($items)] [Without arguments params]
	 * @uses [\APIHelper::transformCollection($items, ['created_at', 'status', 'updated_at'])] [With arguments params]
	 */
	public static function transformCollection($items, $args = array()) {
		// this function will transform all teh API result

		// check if the data is not the array
		// then update the data
		// else loop throuth the data
		// check id not a array update the data
		// or loop theroth the data

		if (empty($items)) {
			return $items;
		}

		foreach ($items as $key => $value) {
			if (is_array($value)) {
				$items[$key] = self::transformCollection($value);
			} else {
				if (count($value) != 0) {

					if (!empty($args)) {
						foreach ($args as $k => $v) {
							unset($items[$key][$v]);
						}
					} else {
						unset($items[$key]->created_at);
						unset($items[$key]->updated_at);
						unset($items[$key]->deleted_at);
					}

				}
			}
		}

		return $items;
	}

	/**
	 * This function will transform the single object of data
	 * @param [array] $[item] [This is single object data where we want to perform transform]
	 * @param [array] $[args] [(optional) It will take fields which all we want to remove from the array ex 'created_at' otherwise by default it will remove 'created_at, deleted_at, updated_at' fields from array]
	 * @uses [\APIHelper::transform($item)] [Without arguments params]
	 * @uses [\APIHelper::transform($item, ['created_at', 'status', 'updated_at'])] [With arguments params]
	 */
	public static function transform($item, $args = array()) {
		// this function will transform all teh API result

		if (count($item) != 0) {

			if (!empty($args)) {
				foreach ($args as $k => $v) {
					unset($item[$v]);
				}
			} else {
				unset($item->created_at);
				unset($item->updated_at);
				unset($item->deleted_at);
			}

		}

		return $item;
	}
}