<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class DropoutReason extends RedlofModel {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'dropout_reasons';

	protected $guarded = ['id'];

	protected $fillable = ['registration_id', 'reason'];

	protected $dates = ['deleted_at'];

}