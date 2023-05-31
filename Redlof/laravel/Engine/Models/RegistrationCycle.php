<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class RegistrationCycle extends RedlofModel
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'registration_cycles';

    protected $casts = [
        'preferences' => 'array',
        'nearby_preferences' => 'array',
        'meta_data' => 'array',
    ];

    protected $fillable = ['enrolled_on', 'document_verification_status', 'doc_reject_reason', 'registration_id', 'preferences', 'nearby_preferences', 'cycle', 'status', 'allotted_school_id', 'application_cycle_id', 'meta_data'];

    protected $dates = ['deleted_at'];

    protected $appends = ['doc_verification_status', 'fmt_status'];

    public function basic_details()
    {
        return $this->belongsTo('Models\RegistrationBasicDetail', 'registration_id');
    }

    public function application_details()
    {
        return $this->belongsTo('Models\ApplicationCycle', 'application_cycle_id')
            ->select('id', 'reg_start_date', 'reg_end_date', 'session_year', 'cycle', 'trigger_type', 'status', 'stu_reg_start_date', 'stu_reg_end_date', 'is_latest', 'created_at');
    }

    public function school()
    {
        return $this->belongsTo('Models\School', 'allotted_school_id')
            ->select('id', 'udise', 'name', 'phone', 'address', 'district_id', 'locality_id', 'block_id', 'sub_block_id', 'levels');
    }

    public function getFmtStatusAttribute()
    {
        if (isset($this->attributes['status'])) {

            return ucwords($this->attributes['status']);
        }
    }
    public function getDocVerificationStatusAttribute()
    {
        if (isset($this->attributes['document_verification_status'])) {

            return ucwords($this->attributes['document_verification_status']);
        }
    }

}
