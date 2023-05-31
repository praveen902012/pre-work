<?php
namespace Models;

use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class Gallery extends RedlofModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'galleries';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['name', 'brief', 'isfeatured', 'state_id'];

	protected $appends = ['fmt_name'];

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

	public function getFmtNameAttribute($value) {

		$value = null;

		if (isset($this->attributes['name'])) {
			if (!empty($this->attributes['name'])) {
				$value = \AWSHelper::getSignedUrl('gallery/' . $this->attributes['name']);
			} else {
				$value = \AWSHelper::getSignedUrl('state/thumb/default.png');
			}
		}

		return $value;
	}

	protected $dates = ['deleted_at'];

}