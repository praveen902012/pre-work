<?php namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class State extends RedlofModel {
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'states';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['name', 'slug', 'logo', 'language_id', 'documents'];

	protected $appends = ['fmt_logo'];

	public function getNameAttribute($value) {
		return title_case($value);
	}

	public function setNameAttribute($value) {
		$this->attributes['name'] = title_case($value);
	}

	public function getFmtLogoAttribute($value) {

		$value = null;

		if (isset($this->attributes['logo'])) {
			if (!empty($this->attributes['logo'])) {
				$value = \AWSHelper::getSignedUrl('state/thumb/' . $this->attributes['logo']);
			} else {
				$value = \AWSHelper::getSignedUrl('state/thumb/default.png');
			}
		}

		return $value;
	}

	protected $dates = ['deleted_at'];

	public function stateadmin() {
		return $this->hasOne('Models\StateAdmin')->select('id', 'state_id', 'user_id');
	}

	public function application_cycle() {
		return $this->hasMany('Models\ApplicationCycle', 'state_id');
	}

	public function language() {
		return $this->belongsTo('Models\Language')->select('id', 'name');
	}

	public function total_district_admins() {
		return $this->hasOne('Models\StateDistrictAdmin', 'state_id')
			->selectRaw('state_id, count(*) as total')
			->groupBy('state_id');
	}

	public function total_state_admins() {
		return $this->hasOne('Models\StateAdmin', 'state_id')
			->selectRaw('state_id, count(*) as total')
			->where('status', 'active')
			->groupBy('state_id');
	}

	public function total_districts() {
		return $this->hasOne('Models\District', 'state_id')
			->selectRaw('state_id, count(*) as total')
			->where('status', 'active')
			->groupBy('state_id');
	}

	public function total_nodal_admins() {
		return $this->hasOne('Models\StateNodal', 'state_id')
			->selectRaw('state_id, count(*) as total')
			->where('status', 'active')
			->groupBy('state_id')->where('status', 'active');
	}

	public function total_schools() {
		return $this->hasOne('Models\School', 'state_id')
			->selectRaw('state_id, count(*) as total')
			->where('application_status', 'verified')
			->groupBy('state_id');
	}
	public function total_students() {
		return $this->hasOne('Models\RegistrationBasicDetail', 'state_id')
			->where('status', 'completed')
			->selectRaw('state_id, count(*) as total')
			->groupBy('state_id');
	}

}