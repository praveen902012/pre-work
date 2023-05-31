<?php namespace Models;

use Zizaco\Entrust\EntrustPermission;

/**
 * Class Permission
 * @package App
 */
class PermissionRole extends EntrustPermission {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table;

	/**
	 *
	 */
	public function __construct() {
		$this->table = config('entrust.permissions_table');
	}

	/**
	 * Many-to-Many relations with Roles.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */

	/**
	 * Many-to-Many relations with Users.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */

}