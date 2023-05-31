<?php

namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class SuspiciousStudent extends RedlofModel {
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'suspicious_students';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['district_id', 'registration_id', 'schooladmin_id', 'suspicious_reason', 'status'];

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

	public function basic_details() {
		return $this->belongsTo('Models\RegistrationBasicDetail', 'registration_id')->select('id', 'first_name', 'registration_no', 'mobile');
	}

	public function schooladmin() {
		return $this->belongsTo('Models\SchoolAdmin', 'schooladmin_id');
	}

}