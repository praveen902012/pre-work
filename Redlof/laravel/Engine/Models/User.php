<?php namespace Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Redlof\Core\Models\RedlofModel;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * Class User
 * @package App
 */
class User extends RedlofModel implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, EntrustUserTrait, Notifiable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	protected $appends = ['display_name', 'photo_thumb'];

	protected $dates = ['deleted_at'];

	public function getPhotoThumbAttribute($value) {
		if (isset($this->attributes['photo'])) {
			return \AWSHelper::getSignedUrl('userphotos/thumb/' . $this->attributes['photo']);
		}
		return NULL;
	}

	public function setPasswordAttribute($value) {
		if (\Hash::needsRehash($value)) {
			$this->attributes['password'] = bcrypt($value);
		} else {
			$this->attributes['password'] = $value;
		}

	}

	public function getDisplayNameAttribute() {
		$value = null;

		if (isset($this->attributes['first_name'])) {
			$value = $this->attributes['first_name'];
		}

		if (isset($this->attributes['last_name'])) {
			$value = $value . ' ' . $this->attributes['last_name'];
		}

		return $value;

	}

	public function roleuser() {
		return $this->hasMany('Models\RoleUser', 'user_id');
	}

	public function userrole() {
		return $this->hasOne('Models\RoleUser', 'user_id');
	}

	public function setFirstNameAttribute($value) {
		$this->attributes['first_name'] = ucfirst($value);
	}

	public function setLastNameAttribute($value) {
		$this->attributes['last_name'] = ucfirst($value);
	}

}