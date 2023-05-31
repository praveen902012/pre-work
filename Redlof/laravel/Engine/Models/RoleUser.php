<?php namespace Models;
use Redlof\Core\Models\RedlofModel;

/**
 * Class SubUser
 * @package App
 */
class RoleUser extends RedlofModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'role_user';

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

	public function role() {
		return $this->belongsTo('Models\Role');
	}

}