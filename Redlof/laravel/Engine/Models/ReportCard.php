<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class ReportCard extends RedlofModel {
	use SoftDeletes;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'report_cards';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['school_id', 'application_year', 'level_id', 'year', 'tution_payable', 'amount_payable', 'other_payable', 'status', 'payment_status', 'tution_fee_status', 'other_fee_status', 'registration_id', 'student_status', 'dropped_at'];

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

	public function student() {

		return $this->belongsTo('Models\RegistrationBasicDetail', 'registration_id');
	}

	public function school() {

		return $this->belongsTo('Models\School', 'school_id');
	}

	public function grade_report() {

		return $this->hasMany('Models\GradeReport', 'report_id');
	}

	public function attendance_report() {

		return $this->hasMany('Models\AttendanceReport', 'report_id');
	}

	public function total_months_present() {

		return $this->hasOne('Models\AttendanceReport', 'report_id')
			->selectRaw('report_id, count(*) as total')
			->where('total_days', '>', 0)
			->groupBy('report_id');
	}

	public function total_grade_report() {

		return $this->hasMany('Models\GradeReport', 'report_id')
			->selectRaw('report_id, count(distinct report_id) as total')
			->groupBy('report_id');
	}

}