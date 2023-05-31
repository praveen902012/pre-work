<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class Chat
 * @package App
 */
class SystemCommunication extends RedlofModel {

	use SoftDeletes;

	protected $table = 'system_communications';

	protected $casts = [
		'content' => 'array',
	];

	protected $fillable = ['user_id', 'email', 'type', 'content', 'trigger_time', 'expiry_time'];
	protected $dates = ['deleted_at'];

	public function setContentAttribute($value) {
		$this->attributes['content'] = json_encode($value);
	}

	public function getContentAttribute($value) {
		return json_decode($value);
	}

}