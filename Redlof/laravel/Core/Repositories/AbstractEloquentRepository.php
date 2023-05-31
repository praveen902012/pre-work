<?php
namespace Redlof\Core\Repositories;

abstract class AbstractEloquentRepository {
	public function make(array $with = array()) {
		return $this->model->with($with);
	}

	public function create($request) {
		return $this->model->create($request->all());
	}

	public function createByArray($request) {
		return $this->model->create($request);
	}

	public function get($id) {
		return $this->model->find($id);
	}

	public function getAllList() {
		return $this->model->get();
	}

	public function getAll($input, $args = []) {

		$columns = ['*'];
		$limit = 10;
		$currentslice = 1;
		$status = '';
		$skip = 0;
		$takeall = false;

		$Results = array();

		// Get the total results
		$totalObj = $this->model;
		$Models = $this->model;

		if (isset($input['status']) && $input['status'] != '') {
			$totalObj = $totalObj->where('status', $input['status']);
		}

		if (!empty($args['where_array'])) {

			foreach ($args['where_array'] as $where) {
				$operator = isset($where[2]) ? $where[1] : '=';
				$value = isset($where[2]) ? $where[2] : $where[1];
				$totalObj = $totalObj->where($where[0], $operator, $value);
				$Models = $Models->where($where[0], $operator, $value);
			}

		}

		// Make an option to create query for whereIn
		if (!empty($args['where_in'])) {
			$where_in = $args['where_in'];
			$totalObj = $totalObj->whereIn($where_in[0], $where_in[1]);
			$Models = $Models->whereIn($where_in[0], $where_in[1]);
		}

		// Make an option to create query for where NUll
		if (!empty($args['where_null'])) {
			$where_null = $args['where_null'];
			$totalObj = $totalObj->whereNull($where_null[0]);
			$Models = $Models->whereNull($where_null[0]);
		}

		// Make an option to create query for where Not NUll
		if (!empty($args['where_not_null'])) {
			$where_not_null = $args['where_not_null'];
			$totalObj = $totalObj->whereNotNull($where_not_null[0]);
			$Models = $Models->whereNotNull($where_not_null[0]);
		}

		// Create where clause to compare whereDate
		if (!empty($args['where_date'])) {

			foreach ($args['where_date'] as $where_date_arr) {

				$operator = isset($where_date_arr[2]) ? $where_date_arr[1] : '=';

				$value = isset($where_date_arr[2]) ? $where_date_arr[2] : $where_date_arr[1];

				$totalObj = $totalObj->whereDate($where_date_arr[0], $operator, $value);

				$Models = $Models->whereDate($where_date_arr[0], $operator, $value);
			}

		}

		$total = $totalObj->count();

		// Filter the query params to select
		if (isset($input['params']) && $input['params'] != '') {
			$columns = $input['params'];
			$columns = array_map('trim', explode(',', $columns));
		}

		if (!empty($args['where_has'])) {
			$Models = $Models->whereHas($args['where_has']['relation'], function ($query) use ($args) {
				$query->where($args['where_has']['fields']);
			});
		}

		if (isset($input['keyword']) && $input['keyword'] != '') {
			$keyword = isset($input['keyword']) ? $input['keyword'] : '';

			$search_count = 0;

			if (!empty($args['search_fields'])) {

				foreach ($args['search_fields'] as $field) {

					if ($search_count < 1) {
						$Models = $Models->where($field, 'ilike', '%' . $keyword . '%');

					} else {
						$Models = $Models->orWhere($field, 'ilike', '%' . $keyword . '%');
					}

					++$search_count;
				}

			}

			if (!empty($args['relation_search'])) {

				$relationsearct_count = 0;

				$Models = $Models->whereHas($args['relation_search']['relation'], function ($query) use ($args, $keyword, $relationsearct_count) {

					foreach ($args['relation_search']['fields'] as $relationsearch) {
						if ($relationsearct_count < 1) {
							$query->where($relationsearch, 'like', '%' . $keyword . '%');
						} else {
							$query->orWhere($relationsearch, 'like', '%' . $keyword . '%');
						}

						++$relationsearct_count;

					}
				});

			}

		}

		if (isset($input['takeall']) && $input['takeall'] != '') {
			$takeall = $input['takeall'];
			$takeall = ($takeall == 'false') ? false : true;
		}

		if (isset($input['limit']) && $input['limit'] != '') {
			$limit = (int) $input['limit'];
		}

		if (isset($input['skip']) && $input['skip'] != '') {
			$skip = (int) $input['skip'];
		}

		if (isset($input['status']) && $input['status'] != '') {
			$Models = $Models->where('status', $input['status']);
		}

		// Selection
		$Models = $Models->select($columns);

		//Relation
		if (!empty($args['relations'])) {
			$Models = $Models->with($args['relations']);
		}

		//Sorting
		if (isset($input['sortby'])) {

			if ($input['sortby'] == 'newest') {

				$Models = $Models->orderBy('created_at', 'desc');

			} else if ($input['sortby'] == 'oldest') {

				$Models = $Models->orderBy('created_at', 'asc');

			} else if ($input['sortby'] == 'name') {

				$Models = $Models->orderBy($input['sortby'], 'asc');

			} else {
				$Models = $Models->orderBy('created_at', 'desc');
			}
		}

		if (!empty($args['custom_order'])) {
			$Models->orderBy($args['custom_order'][0], $args['custom_order'][1]);
		} else {
			$Models->orderBy('created_at', 'desc');
		}

		if ($takeall) {
			$Models = $Models->get();
		} else {
			$Models = $Models->skip($skip)->take($limit);
			$Models = $Models->get();
		}

		// Calculate the pageNumber & pass the currentSlice

		$currentslice = ceil($skip / $limit) + 1;

		$Results['total'] = $total;
		$Results['currentslice'] = $currentslice;
		$Results['limit'] = $limit;
		$Results['pagination'] = ceil($total / $limit);
		$Results['items'] = $Models;

		return $Results;
	}

	/**
	 * Find a model by an id
	 * @param  $id
	 * @param  array $with Relations
	 * @param  mixed $status (optional)
	 * @return \Illuminate\Database\Eloquent\Model|static|null
	 **/
	public function getById($id, array $with = array(), $status = null) {
		$query = $this->make($with);

		if ($status) {
			return $query->where('status', $status)->find($id);
		}

		return $query->find($id);
	}

	/**
	 * Find a model based on column value
	 * @param  $col_name
	 * @param  $value
	 * @param  $operator (optional)
	 * @return \Illuminate\Database\Eloquent\Model|static|null
	 **/
	public function getByValue($col_name, $value, $operator = '=') {
		return $this->model->where($col_name, $operator, $value)->first();
	}

	/**
	 * Retrieve all model
	 * @param  $col_name
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 **/
	public function getAllOld($status = null) {
		//TODO: Change the name to actual name
		$query = $this->model;

		if ($status) {
			$query = $query->where('status', $status);
		}

		return $query->get();
	}

	/**
	 * Retrieve all model
	 * @param array $with , Relations
	 * @param mixed $status
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 **/
	public function getAllWithRelations(array $with = array(), $status = null) {
		$query = $this->make($with);

		if ($status != null) {
			$query->where('status', $status);
		}

		return $query->get();
	}

	public function getByValueWithRelation($col_name, $value, array $with = array(), $status = null, $operator = '=') {
		$query = $this->make($with);

		$query->where($col_name, $operator, $value);

		if ($status != null) {
			$query->where('status', $status);
		}

		return $query->first();
	}

	/**
	 * Retrieve all model based on value with relations
	 * @param col_name
	 * @param value
	 * @param array $with , Relations
	 * @param mixed $status
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 **/
	public function getAllValueWithRelations($col_name, $value, array $with = array(), $status = null, $operator = '=', $paginate = true) {
		$query = $this->make($with);

		$query->where($col_name, $operator, $value);

		if ($status != null) {
			$query->where('status', $status);
		}

		if ($paginate == true) {
			return $query->paginate(10);
		}

		return $query->get();
	}

	/**
	 * Retrieve all model based on value
	 * @param $col_name
	 * @param $value
	 * @param mixed $status
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 **/
	public function getAllByValue($col_name, $value, $status = null, $operator = '=') {
		$Query = $this->model->where($col_name, $operator, $value);

		if ($status) {
			$Query = $Query->where('status', $status);
		}

		return $Query->get();
	}

	/**
	 * Update model based
	 * @param $id
	 * @param mixed $status
	 * @return \Illuminate\Database\Eloquent\Collection|static|null
	 **/
	public function updateStatus($id, $status) {
		$Model = $this->getById($id);

		$Model->status = $status;

		$Model->save();

		return $Model;
	}

	/**
	 * Fetch model by limiting number of results returned from query
	 * @param array $with - relations
	 * @param mixed $status - status
	 * @param int skip - offset to skip
	 * @param int take - offset to take
	 * @return \Illuminate\Database\Eloquent\Collection|static|null
	 **/
	public function getAllWithRelationsSkipAndTake(array $with = array(), $status = null, $skip, $take) {
		$query = $this->make($with);

		if ($status != null) {
			$query->where('status', $status);
		}

		return $query->skip($skip)->take($take)->get();
	}

	public function changeStatus($id, $status) {
		$object = $this->model->find($id);

		// Update the status
		$object->status = $status;

		if (!$object->update()) {
			throw new EntryCreationFailed;
		}

		return $this->get($object->id);
	}

	public function delete($id) {
		$object = $this->model->find($id);
		$object->delete();

		return true;
	}

	public function forceDelete($id) {
		$object = $this->model->find($id);
		$object->forceDelete();

		return true;
	}
}
