<?php namespace Models;

use Zizaco\Entrust\EntrustRole;

/**
 * Class Role
 * @package App
 */
class Role extends EntrustRole {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	/**
	 *
	 */
	public function __construct() {

	}

	public function user() {
		return $this->belongsTo('Models\User');
	}

}