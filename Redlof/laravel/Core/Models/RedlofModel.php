<?php
namespace Redlof\Core\Models;

use Illuminate\Database\Eloquent\Model;

class RedlofModel extends Model {

	public function scopeFindItem($query, $id) {
		return $query->where('id', $id)->get();
	}

	public function scopeSearch($query, $request, $columns) {

		$keyword = $request['s'];
		$keywords = explode(' ', $keyword);

		$first = true;

		foreach ($keywords as $q) {

			foreach ($columns as $col) {

				if ($first) {

					$query->where($col, 'ilike', "%$q%");

					$first = false;

				} else {

					$query->orWhere($col, 'ilike', "%$q%");
				}

			}
		}

		return $query;
	}

	public function scopeStatus($query, $column = 'status', $value) {
		return $query->where($column, $value);
	}

	public function scopePage($query, &$request) {

		// set default limit
		$limit = 10;
		$skip = 0;
		$currentslice = 1;

		if (isset($request['limit']) && $request['limit'] != '') {
			$limit = (int) $request['limit'];
		}

		if (isset($request['skip']) && $request['skip'] != '') {
			$skip = (int) $request['skip'];
		}

		$total = $query->count();
		$currentslice = ceil($skip / $limit) + 1;
		$pagination = ceil($total / $limit);

		$request->merge([
			'total' => $total,
			'currentslice' => $currentslice,
			'limit' => $limit,
			'pagination' => $pagination,
		]);

		return $query->skip($skip)->take($limit);
	}

	public function newCollection(array $models = []) {
		return new RedlofCollection($models);
	}

}