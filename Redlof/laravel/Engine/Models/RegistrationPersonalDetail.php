<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class RegistrationPersonalDetail extends RedlofModel {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'registration_personal_details';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [
		'certificate_details' => 'array',
		'files' => 'array',
	];

	protected $fillable = ['registration_id', 'category', 'certificate_details', 'parent_type', 'parent_name', 'parent_mobile_no', 'parent_id_proof', 'parent_profession', 'residential_address', 'locality_id', 'block_id', 'pincode', 'files', 'district_id', 'address_proof', 'lat', 'lng', 'venue','state_type','sub_block_id'];

	protected $appends = ['fmt_files'];

	public function setParentNameAttribute($value) {
		$this->attributes['parent_name'] = title_case($value);
	}

	public function getCertificateDetailsAttribute($value) {
		$value = json_decode($value, true);

		// if (!empty($value)) {
		// 	foreach ($value as $key => $val) {
		// 		if (strpos($key, 'cerificate')) {
		// 			$value[$key] = intval($value[$key]);
		// 		}

		// 		if ($key == 'bpl_income') {
		// 			$value[$key] = intval($value[$key]);
		// 		}
		// 	}
		// }

		return $value;
	}

	public function getFmtFilesAttribute() {

		if (isset($this->attributes['files'])) {

			$documents = [];

			$value = json_decode($this->attributes['files']);

			if (isset($value->address_proof) && !empty($value->address_proof)) {

				$documents['address_proof'] = \AWSHelper::getSignedUrl('students/' . $value->address_proof->f);

			}

			if (isset($value->birth_certificate) && !empty($value->birth_certificate)) {

				$documents['birth_certificate'] = \AWSHelper::getSignedUrl('students/' . $value->birth_certificate->f);

			}

			if (isset($value->child_aadhar_card) && !empty($value->child_aadhar_card)) {

				$documents['child_aadhar_card'] = \AWSHelper::getSignedUrl('students/' . $value->child_aadhar_card->f);

			}

			if (isset($value->income_certificate) && !empty($value->income_certificate)) {

				$documents['income_certificate'] = \AWSHelper::getSignedUrl('students/' . $value->income_certificate->f);

			}

			if (isset($value->parent_aadhar_card) && !empty($value->parent_aadhar_card)) {

				$documents['parent_aadhar_card'] = \AWSHelper::getSignedUrl('students/' . $value->parent_aadhar_card->f);

			}

			return $documents;
		}

	}

	public function basic_details() {
		return $this->belongsTo('\Models\RegistrationBasicDetail', 'registration_id', 'id');
	}

	public function subsublocality() {
		return $this->belongsTo('Models\SubSubLocality', 'sub_sub_locality_id');
	}

	public function sublocality() {
		return $this->belongsTo('Models\SubLocality', 'sub_locality_id');
	}

	public function locality() {
		return $this->belongsTo('Models\Locality', 'locality_id');
	}

	public function district() {
		return $this->belongsTo('Models\District', 'district_id');
	}

	public function block() {
		return $this->belongsTo('Models\Block', 'block_id');
	}

	public function parent_details() {
		return $this->hasOne('\Models\RegistrationParentDetail', 'registration_id', 'registration_id')->select('id', 'registration_id', 'parent_type', 'parent_name')
			->orderBy('created_at', 'asc');
	}

	protected $dates = ['deleted_at'];

}