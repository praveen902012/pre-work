<?php
namespace Redlof\Engine\Auth\Repositories;

use Models\Role;
use Redlof\Core\Repositories\AbstractEloquentRepository;

/**
 * Class EloquentRoleRepository
 * @package App\Repositories\Role
 */
class RoleRepo extends AbstractEloquentRepository {

	function __construct() {
		$this->model = new Role();
	}

	public function getAllRoles() {
		return Role::select('name', 'id', 'display_name')->get();
	}

	public function get($name) {
		return Role::where('name', '=', $name)->first();
	}
}
