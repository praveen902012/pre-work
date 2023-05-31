<?php namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class SchoolNodal extends RedlofModel {

	use SoftDeletes;

	protected $table = 'school_nodals';

	protected $fillable = ['school_id', 'nodal_id'];

	public function nodaladmin() {
		return $this->belongsTo('Models\StateNodal', 'nodal_id')->select('id', 'state_id', 'user_id');
	}

	public function school() {
		return $this->belongsTo('Models\School', 'school_id');
	}

}