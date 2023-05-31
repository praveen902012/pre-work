<?php
namespace Redlof\Core\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProfileImageUpload extends Job implements SelfHandling, ShouldQueue {
	use InteractsWithQueue, SerializesModels;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */

	protected $file_path;
	protected $file_name;
	protected $folder_name;

	public function __construct($file_path, $file_name, $folder_name) {
		$this->file_path = $file_path;
		$this->file_name = $file_name;
		$this->folder_name = $folder_name;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {

		// we need to upload the original image & few copies of resized version

		\AWSHelper::pushToS3WithBody($this->file_name, $this->file_path, $this->folder_name);

		// Resize image from temp directory
		// upload that to amazon s3 -> image oobject

		// Resize image from temp directory
		// upload that to amazon s3 -> image oobject

		// Resize image from temp directory
		// upload that to amazon s3 -> image oobject

		\ImageHelper::resizeImage($this->file_name, 200, 200, $this->folder_name, $this->folder_name);

		\ImageHelper::resizeImage($this->file_name, 80, 80, $this->folder_name, $this->folder_name . '/thumb');

		// call the clear method with the filename
		\AppHelper::cleanTempFile($this->file_name);
	}
}
