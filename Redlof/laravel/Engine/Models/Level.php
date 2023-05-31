<?php namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class Level extends RedlofModel {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'levels';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['level'];

	public function setNameAttribute($value) {
		$this->attributes['name'] = title_case($value);
	}

	protected $dates = ['deleted_at'];

	public function level_info() {
		return $this->hasMany('Models\SchoolLevelInfo', 'level_id');
	}

}