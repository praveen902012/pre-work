<?php
namespace Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redlof\Core\Models\RedlofModel;

/**
 * Class User
 * @package App
 */
class Document extends RedlofModel {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'documents';

	protected $guarded = ['id'];

	protected $fillable = ['title', 'description', 'doc', 'doc_image'];

    protected $dates = ['deleted_at'];

	public function getFmtDocAttribute()
    {
		// return getFileUrl($this->attributes['doc']);
		$value = null;

		if (isset($this->attributes['doc'])) {
			if (!empty($this->attributes['doc'])) {
				$value = \AWSHelper::getSignedUrl($this->attributes['doc']);
			} else {
				$value = \AWSHelper::getSignedUrl('state/thumb/default.png');
			}
		}

		return $value;
	}
	
	public function getFmtDocImageAttribute()
    {
		// return getFileUrl($this->attributes['doc']);
		$value = null;

		if (isset($this->attributes['doc_image'])) {
			if (!empty($this->attributes['doc_image'])) {
				$value = \AWSHelper::getSignedUrl($this->attributes['doc_image']);
			} else {
				$value = \AWSHelper::getSignedUrl('state/thumb/default.png');
			}
		}

		return $value;
    }
}