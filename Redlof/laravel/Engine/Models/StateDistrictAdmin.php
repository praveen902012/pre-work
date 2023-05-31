<?php namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class StateDistrictAdmin extends RedlofModel {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'state_district_admins';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['state_id', 'user_id', 'status'];

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
		return $this->belongsTo('Models\User')->select('id', 'first_name', 'last_name', 'email', 'phone');
	}

	public function state() {
		return $this->belongsTo('Models\State')->select('id', 'name');
	}

	public function district() {
		return $this->belongsTo('Models\District')->select('id', 'state_id', 'name');
	}

}