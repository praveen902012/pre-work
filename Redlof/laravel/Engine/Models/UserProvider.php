<?php namespace Models;
use Redlof\Core\Models\RedlofModel;

/**
 * Class UserProvider
 * @package App
 */
class UserProvider extends RedlofModel {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_providers';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

}