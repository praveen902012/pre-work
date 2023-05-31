<?php namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class School extends RedlofModel
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'schools';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $fillable = ['name', 'logo', 'phone', 'website', 'address', 'state_id', 'district_id', 'locality_id', 'lat', 'lng', 'pincode', 'status', 'application_status', 'udise', 'language_id', 'eshtablished', 'block_id', 'max_fees', 'levels', 'type', 'description', 'reject_reason', 'accept_reason', 'recheck_reason', 'current_state', 'school_type', 'state_type', 'sub_block_id', 'cycle', 'cluster_id', 'rte_certificate_no'];

    protected $appends = ['fmt_logo'];

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

    public function schooladmin()
    {
        return $this->hasOne('Models\SchoolAdmin');
    }

    public function language()
    {
        return $this->belongsTo('Models\Language');
    }

    public function schoolcycle()
    {
        return $this->hasMany('Models\SchoolCycle', 'school_id');
    }

    public function nodal()
    {
        return $this->hasMany('Models\StateNodal');
    }

    public function registration_cycle()
    {
        return $this->hasMany('Models\RegistrationCycle', 'allotted_school_id');
    }

    public function allotted_students()
    {
        return $this->hasMany('Models\RegistrationCycle', 'allotted_school_id')->whereIn('status', ['enrolled', 'allotted']);
    }

    public function school_nodal()
    {
        return $this->hasOne('Models\SchoolNodal');
    }

    public function regions()
    {
        return $this->hasMany('Models\SchoolRange');
    }

    public function getLevelsAttribute($value)
    {
        return json_decode($value);
    }

    public function setLevelsAttribute($value)
    {
        $this->attributes['levels'] = json_encode($value);
    }

    public function state()
    {
        return $this->belongsTo('Models\State')->select('id', 'name', 'slug');
    }

    public function district()
    {
        return $this->belongsTo('Models\District', 'district_id')->select('id', 'name');
    }

    public function locality()
    {
        return $this->belongsTo('Models\Locality', 'locality_id')->select('id', 'name');
    }

    public function cluster()
    {
        return $this->belongsTo('Models\Cluster', 'cluster_id')->select('id', 'name');
    }

    public function sublocality()
    {
        return $this->belongsTo('Models\SubLocality', 'sub_locality_id')->select('id', 'name');
    }

    public function subsublocality()
    {
        return $this->belongsTo('Models\SubSubLocality', 'sub_sub_locality_id')->select('id', 'name');
    }

    public function block()
    {
        return $this->belongsTo('Models\Block', 'block_id')->select('id', 'name', 'type');
    }

    public function subblock()
    {
        return $this->belongsTo('Models\Block', 'sub_block_id')->select('id', 'name', 'type');
    }

    public function total_seats_available()
    {
        return $this->hasOne('Models\SchoolLevelInfo', 'school_id')
            ->selectRaw('school_id, sum(available_seats) as total')
            ->groupBy('school_id');
    }

    public function total_seats_allotted()
    {
        return $this->hasMany('Models\RegistrationCycle', 'allotted_school_id')->whereIn('status', ['allotted', 'enrolled']);
    }

    public function level_infos()
    {
        return $this->hasMany('Models\SchoolLevelInfo', 'school_id');
    }

    public function report_card()
    {
        return $this->hasMany('Models\ReportCard', 'school_id');
    }

    public function school_reimbursement()
    {
        return $this->hasOne('Models\SchoolReimbursement', 'school_id');
    }

    public function school_bank_details()
    {
        return $this->hasOne('Models\SchoolBankDetails', 'school_id');
    }

    public function allotment_statistics()
    {
        return $this->hasOne('Models\AllottmentStatistic', 'school_id');
    }

    public function total_tution_fees()
    {
        return $this->hasOne('Models\ReportCard', 'school_id')
            ->selectRaw('school_id, sum(tution_payable) as total')
            ->groupBy('school_id');
    }

    public function getFmtLogoAttribute($value)
    {

        $value = null;

        if (isset($this->attributes['logo'])) {
            if (!empty($this->attributes['logo'])) {
                $value = \AWSHelper::getSignedUrl('school/' . $this->attributes['logo']);
            } else {
                $value = \AWSHelper::getSignedUrl('school/default.png');
            }
        }

        return $value;
    }

    public function school_ranges()
    {
        return $this->hasMany('Models\SchoolRange', 'school_id');
    }

}