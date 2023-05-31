<?php
namespace Redlof\Core\Jobs;

use App\Jobs\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImageUpload extends Job implements ShouldQueue {
	use InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */

	protected $file_path;
	protected $file_name;
	protected $folder_name;
	protected $width;
	protected $height;

	public function __construct($file_path, $file_name, $folder_name, $width, $height) {
		$this->file_path = $file_path;
		$this->file_name = $file_name;
		$this->folder_name = $folder_name;
		$this->width = $width;
		$this->height = $height;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {

		// we need to upload the original image & few copies of resized version

		\AWSHelper::pushToS3WithBody($this->file_name, $this->file_path, $this->folder_name);

		\ImageHelper::resizeImage($this->file_name, $this->width, $this->height, $this->folder_name, $this->folder_name . '/thumb');

		// call the clear method with the filename
		\AppHelper::cleanTempFile($this->file_name);
	}
}
