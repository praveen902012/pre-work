<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class SchoolReimbursement extends RedlofModel {
	use SoftDeletes;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'school_reimbursements';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $fillable = ['school_id', 'reimbursement_amount', 'payment_status', 'payed_on', 'allow_status'];

	protected $appends = ['fmt_dop'];

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

	public function getFmtDopAttribute() {

		if (isset($this->attributes['payed_on'])) {

			return \DateHelper::formatDate($this->attributes['payed_on']);
		}

	}

}