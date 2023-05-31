<?php namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Models\State;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class StateNodal extends RedlofModel {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'state_nodals';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['state_id', 'user_id', 'status', 'district_id'];

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
	protected $dates = ['deleted_at'];

	public function user() {
		return $this->belongsTo('Models\User')->select('id', 'first_name', 'last_name', 'phone', 'email');
	}

	public function state() {
		return $this->belongsTo('Models\State')->select('id', 'name', 'slug');
	}

	public function district() {
		return $this->belongsTo('Models\District')->select('id', 'name');
	}

	public function school_nodal() {
		return $this->hasMany('Models\SchoolNodal');
	}

	public function assigned_nodal() {
		return $this->hasOne('Models\NodaladminBlock','state_nodals_id');
	}
}