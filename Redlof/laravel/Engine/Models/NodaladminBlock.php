<?php namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class NodaladminBlock extends RedlofModel {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'nodaladmin_blocks';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['block_id', 'state_nodals_id', 'status'];

	protected $dates = ['deleted_at'];

	public function block() {
		return $this->belongsTo('Models\Block', 'block_id');
	}

    public function nodaladmin() {
		return $this->belongsTo('Models\StateNodal', 'state_nodals_id');
	}

}