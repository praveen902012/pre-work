<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class DenyAdmission extends RedlofModel {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'deny_admissions';

	protected $fillable = ['registration_id', 'status'];

	protected $dates = ['deleted_at'];

	public function basic_details() {
		return $this->belongsTo('Models\RegistrationBasicDetail', 'registration_id');
	}

}