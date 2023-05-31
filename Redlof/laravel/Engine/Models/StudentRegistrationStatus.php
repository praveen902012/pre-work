<?php

namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class StudentRegistrationStatus extends RedlofModel {
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'student_registration_status';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['district_id', 'status'];

	protected $appends = ['fmt_doc'];

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

	protected $dates = ['deleted_at', 'closing_date'];

	public function getFmtDocAttribute() {

		if (isset($this->attributes['closing_date'])) {

			return \DateHelper::formatDate($this->attributes['closing_date']);
		}

	}

	public function district() {
		return $this->belongsTo('Models\District')->select('id', 'name');
	}

}