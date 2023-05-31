<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class StateSubject extends RedlofModel {
	use SoftDeletes;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'state_subjects';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['subject_id', 'level_id', 'stateadmin_id', 'state_id'];

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

	public function level() {
		return $this->belongsTo('\Models\Level')->select('id', 'level')->orderBy('id');
	}

	public function subject() {
		return $this->belongsTo('Models\Subject')->select('id', 'name');
	}

}