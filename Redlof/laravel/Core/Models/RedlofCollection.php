<?php
namespace Redlof\Core\Models;

use Illuminate\Database\Eloquent\Collection;

class RedlofCollection extends Collection {

	public function trimTimeStamps() {

		$this->transform(function ($item, $key) {
			return collect($item)->except(['created_at', 'updated_at', 'deleted_at']);
		});

		return $this;
	}

	public function imagePath($path, $value, $isSigned = true) {

		$this->transform(function ($item, $key) use ($path, $value, $isSigned) {
			$item = collect($item);

			if ($isSigned) {
				$item[$value] = \AWSHelper::getSignedUrl($path . '/' . $item[$value]);
			} else {
				$item[$value] = \AWSHelper::getFromS3($item[$value], $path);
			}

			return $item;
		});

		return $this;
	}

	public function formatDate($value = 'created_at', $holder = 'created_at', $format = "jS M Y") {

		$this->transform(function ($item, $key) use ($value, $format, $holder) {
			$item = collect($item);

			$carbon = new \Carbon\Carbon($item[$value]);
			$item[$holder] = $carbon->format($format);

			return $item;
		});

		return $this;
	}

	public function humaneDate($value = 'created_at', $holder = 'created_at') {

		$this->transform(function ($item, $key) use ($value, $holder) {
			$item = collect($item);

			$carbon = new \Carbon\Carbon($item[$value]);
			$item[$holder] = $carbon->diffForHumans();

			return $item;
		});

		return $this;
	}

	public function removeData($array_values) {

		$this->transform(function ($item, $key) use ($array_values) {

			return collect($item)->except($array_values);
		});

		return $this;
	}

	public function makeUpEntity($entity, $value) {

		$this->transform(function ($item, $key) use ($entity, $value) {
			$item = collect($item);

			if (!$item->contains($entity)) {
				$item[$entity] = null;
			}

			if (empty($item[$entity])) {
				$item[$entity] = $value;
			}

			return $item;
		});

		return $this;
	}

	public function stripTags($field, $holder = NULL) {

		$this->transform(function ($item, $key) use ($field, $holder) {

			$content = strip_tags($item[$field]);
			$content = preg_replace('/\s+/', ' ', $content);

			if ($holder == NULL) {
				$item[$field] = $content;
			} else {
				$item[$holder] = $content;
			}

			return $item;
		});

		return $this;
	}

	public function trimText($field, $limit = 180, $holder = null) {

		$this->transform(function ($item, $key) use ($field, $limit, $holder) {

			$content = str_limit($item[$field], $limit, '...');

			if ($holder == NULL) {
				$item[$field] = $content;
			} else {
				$item[$holder] = $content;
			}

			return $item;
		});

		return $this;
	}

	public function preparePage($request) {

		$data = [];

		$data['items'] = $this->items;

		$data['total'] = $request['total'];
		$data['currentslice'] = $request['currentslice'];
		$data['limit'] = $request['limit'];
		$data['pagination'] = $request['pagination'];

		return $data;
	}

}