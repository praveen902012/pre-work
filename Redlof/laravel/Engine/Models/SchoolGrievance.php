<?php

namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class SchoolGrievance extends RedlofModel {
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'school_grievances';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['district_id', 'registration_no', 'school_name', 'status'];

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
		return $this->belongsTo('Models\RegistrationBasicDetail', 'registration_no', 'registration_no')->select('id', 'registration_no', 'first_name', 'mobile');
	}

}