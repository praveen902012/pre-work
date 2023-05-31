<?php namespace Models;

use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class Block extends RedlofModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'blocks';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['name', 'district_id', 'updated_at', 'type', 'sub_block'];

	protected $casts = [
		'sub_block' => 'array',
	];

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

	public function district() {
		return $this->belongsTo('Models\District')->select('id', 'name');
	}

	public function locality() {
		return $this->hasMany('Models\Locality', 'block_id')->select('id', 'block_id', 'name');
	}

	public function assignednodaladmin() {
		return $this->hasOne('Models\NodaladminBlock', 'block_id');
	}
}