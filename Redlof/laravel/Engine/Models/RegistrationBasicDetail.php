<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class RegistrationBasicDetail extends RedlofModel
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'registration_basic_details';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    protected $fillable = ['state_id', 'registration_no', 'guid', 'first_name', 'middle_name', 'last_name', 'gender', 'dob', 'mobile', 'email', 'level_id', 'aadhar_no', 'aadhar_enrollment_no', 'status', 'state', 'rejected_document', 'rejected_reason', 'photo_name', 'photo', 'edited_on'];

    protected $appends = ['fmt_dob', 'fmt_dob_form', 'fmt_rejected_document', 'fmt_photo'];

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = title_case($value);
    }

    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middle_name'] = title_case($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = title_case($value);
    }

    public function getFmtDobAttribute()
    {

        if (isset($this->attributes['dob'])) {

            return \DateHelper::formatDate($this->attributes['dob']);
        }

    }

    public function getFmtPhotoAttribute()
    {

        if (isset($this->attributes['photo'])) {

            return \AWSHelper::getSignedUrl($this->attributes['photo']);

        }

    }

    public function getFmtDobFormAttribute()
    {

        if (isset($this->attributes['dob'])) {

            return date('d/m/Y', strtotime($this->attributes['dob']));
        }
    }

    public function getFmtRejectedDocumentAttribute($value)
    {

        $value = null;

        if (isset($this->attributes['rejected_document'])) {
            if (!empty($this->attributes['rejected_document'])) {
                $value = \AWSHelper::getSignedUrl($this->attributes['rejected_document']);
            }
        }

        return $value;
    }

    public function personal_details()
    {
        return $this->hasOne('\Models\RegistrationPersonalDetail', 'registration_id');
    }

    public function parent_details()
    {
        return $this->hasOne('\Models\RegistrationParentDetail', 'registration_id');
    }

    public function all_parent_details()
    {
        return $this->hasMany('\Models\RegistrationParentDetail', 'registration_id');
    }

    public function bank_details()
    {
        return $this->hasOne('\Models\RegistrationBankDetail', 'registration_id');
    }

    public function country_state()
    {
        return $this->belongsTo('Models\State', 'state_id');
    }

    public function report_card()
    {
        return $this->hasOne('\Models\ReportCard', 'registration_id');
    }

    public function dropout_reason()
    {
        return $this->hasOne('\Models\DropoutReason', 'registration_id');
    }

    public function registration_cycle()
    {
        return $this->hasOne('\Models\RegistrationCycle', 'registration_id')->select('id', 'registration_id', 'enrolled_on', 'preferences', 'cycle', 'status', 'application_cycle_id', 'allotted_school_id', 'meta_data', 'nearby_preferences', 'doc_reject_reason', 'document_verification_status', 'created_at')
            ->orderBy('created_at', 'desc');
    }

    public function registration_cycle_latest()
    {
        return $this->hasMany('\Models\RegistrationCycle', 'registration_id')->select('id', 'registration_id', 'enrolled_on', 'preferences', 'cycle', 'status', 'application_cycle_id', 'allotted_school_id', 'meta_data', 'nearby_preferences', 'document_verification_status', 'created_at')
            ->orderBy('created_at', 'desc')->limit(1);
    }

    public function registration_cycle_unique()
    {
        return $this->hasOne('\Models\RegistrationCycle', 'registration_id')->select('id', 'registration_id', 'enrolled_on', 'preferences', 'cycle', 'status', 'application_cycle_id', 'allotted_school_id', 'meta_data', 'nearby_preferences')
            ->distinct('registration_id')
            ->orderBy('created_at', 'desc');
    }

    public function level()
    {
        return $this->belongsTo('\Models\Level')->select('id', 'level');
    }

    public function statename()
    {
        return $this->belongsTo('\Models\State', 'state_id')->select('id', 'name', 'slug');
    }

}
