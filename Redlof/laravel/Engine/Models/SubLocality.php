<?php namespace Models;

use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class SubLocality extends RedlofModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sub_localities';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['locality_id', 'name'];

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

	public function locality() {
		return $this->belongsTo('Models\Locality')->select('id', 'locality_id', 'name');
	}

}