<?php namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class SchoolLevelInfo extends RedlofModel
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'school_level_infos';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $fillable = ['school_id', 'level_id', 'other_fee', 'tution_fee', 'total_seats', 'available_seats', 'dropouts', 'application_cycle_id', 'session_year', 'rte_seats'];

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

    public function level_info()
    {
        return $this->belongsTo('\Models\Level', 'level_id')->select('id', 'level');
    }

    public function seat_info()
    {
        return $this->hasOne('\Models\AllottmentStatistic', 'school_id', 'school_id')
            ->orderBy('year', 'desc');
    }

    public function school()
    {
        return $this->belongsTo('Models\School', 'school_id');
    }

    public function application_cycle()
    {
        return $this->belongsTo('Models\ApplicationCycle', 'application_cycle_id');
    }
}
