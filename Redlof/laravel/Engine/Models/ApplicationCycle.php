<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class ApplicationCycle extends RedlofModel {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'application_cycles';

	protected $fillable = ['is_latest', 'reg_start_date', 'reg_end_date', 'lottery_announcement', 'state_id', 'session_year', 'cycle', 'trigger_type', 'status', 'enrollment_end_date', 'stu_reg_start_date', 'stu_reg_end_date'];

	protected $dates = ['deleted_at'];
	protected $appends = ['orig_reg_start_date', 'orig_reg_end_date', 'orig_stu_reg_start_date', 'orig_stu_reg_end_date'];

	public function state() {
		return $this->belongsTo('Models\State')->select('id', 'name', 'slug');
	}

	public function getRegStartDateAttribute() {
		return \Carbon::parse($this->attributes['reg_start_date'])->format('jS M Y');
	}

	public function getRegEndDateAttribute() {
		return \Carbon::parse($this->attributes['reg_end_date'])->format('jS M Y');
	}

	public function getLotteryAnnouncementDateAttribute() {
		return \Carbon::parse($this->attributes['lottery_announcement_date'])->format('jS M Y');
	}

	public function getLotteryAnnouncementTimeAttribute() {
		return \Carbon::parse($this->attributes['lottery_announcement_time'])->format('g:i A');
	}

	public function getOrigRegStartDateAttribute() {
		if (isset($this->attributes['reg_start_date'])) {

			return $this->attributes['reg_start_date'];
		}

	}

	public function getOrigRegEndDateAttribute() {
		if (isset($this->attributes['reg_end_date'])) {

			return $this->attributes['reg_end_date'];
		}
	}

	public function getOrigStuRegStartDateAttribute() {
		if (isset($this->attributes['stu_reg_start_date'])) {

			return $this->attributes['stu_reg_start_date'];
		}

	}

	public function getOrigStuRegEndDateAttribute() {
		if (isset($this->attributes['stu_reg_end_date'])) {

			return $this->attributes['stu_reg_end_date'];
		}
	}

}