<?php namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class SchoolBankDetails extends RedlofModel
{

    use SoftDeletes;

    protected $table = 'school_bank_details';

    protected $fillable = ['account_number', 'school_id', 'account_holder_name', 'bank_name', 'ifsc_code', 'branch'];

    public function nodaladmin()
    {
        return $this->belongsTo('Models\StateNodal', 'nodal_id')->select('state_id', 'user_id');
    }

    public function school()
    {
        return $this->hasMany('Models\School', 'school_id');
    }

}