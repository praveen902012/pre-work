<?php
namespace Models;
use Redlof\Core\Models\RedlofModel;

/**
 * Class SubUser
 * @package App
 */
class AssignedRole extends RedlofModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'assigned_roles';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * For soft deletes
	 *
	 * @var array
	 */

	public function user() {
		return $this->belongsTo('Models\User', 'user_id', 'id');
	}

	public function role() {
		return $this->belongsTo('Models\Role', 'role_id', 'id');
	}

}
