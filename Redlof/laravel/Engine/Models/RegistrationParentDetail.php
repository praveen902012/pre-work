<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class RegistrationParentDetail extends RedlofModel {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'registration_parent_details';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $dates = ['deleted_at'];

	protected $fillable = ['registration_id', 'parent_type', 'parent_mobile_no', 'parent_profession', 'parent_name'];

	public function basic_details() {
		return $this->belongsTo('Models\RegistrationBasicDetail', 'registration_id');
	}

}