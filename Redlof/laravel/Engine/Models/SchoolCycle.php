<?php namespace Models;

use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class SchoolCycle extends RedlofModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'school_cycles';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['school_id', 'application_cycle_id', 'status'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	/**
	 * For soft deletes
	 *
	 * @var array
	 */

	public function school() {
		return $this->belongsTo('Models\School', 'school_id');
	}

	public function application_cycle() {
		return $this->belongsTo('Models\ApplicationCycle', 'application_cycle_id');
	}


}