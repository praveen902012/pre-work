<?php
namespace Redlof\Core\Repositories;

use Illuminate\Database\Eloquent\Model;
use Redlof\Core\Repositories\AbstractEloquentRepository;

/**
 * Class EloquentGroupRepository
 * @package App\Repositories\Group
 */
class CommonRepo extends AbstractEloquentRepository {

	/**
	 * @var GroupRepositoryContract
	 */
	protected $model;

	function __construct() {
	}

	public function init(Model $model) {

		$this->model = $model;

		return $this;
	}

}