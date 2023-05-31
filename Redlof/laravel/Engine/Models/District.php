<?php namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class District extends RedlofModel
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'districts';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $fillable = ['name'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = title_case($value);
    }

    public function districtadmin()
    {
        return $this->hasOne('Models\StateDistrictAdmin')->select('id', 'district_id', 'user_id');
    }

    public function total_district_admins()
    {
        return $this->hasOne('Models\StateDistrictAdmin', 'district_id')
            ->selectRaw('district_id, count(*) as total')
            ->groupBy('district_id');
    }

    public function state()
    {
        return $this->belongsTo('Models\State')->select('id', 'name');
    }

    public function block()
    {
        return $this->hasMany('Models\Block', 'district_id')->select('id', 'district_id', 'name');
    }
    public function total_schools()
    {
        return $this->hasOne('Models\School', 'district_id')
            ->selectRaw('district_id, count(*) as total')
            ->groupBy('district_id');
    }

    public function total_students()
    {
        return $this->hasOne('Models\RegistrationPersonalDetail', 'district_id')
            ->selectRaw('district_id, count(*) as total')
            ->groupBy('district_id');
    }

}
