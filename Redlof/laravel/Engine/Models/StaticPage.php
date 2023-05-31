<?php namespace Models;

use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class StaticPage extends RedlofModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'static_pages';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['state_id', 'page_id'];

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