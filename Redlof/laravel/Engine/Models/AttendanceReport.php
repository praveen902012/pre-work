<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class AttendanceReport extends RedlofModel {
	use SoftDeletes;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'attendance_reports';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['report_id', 'month', 'total_days', 'attended_days', 'status'];

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

}