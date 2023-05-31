<?php
namespace Redlof\Core\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Redlof\Core\Jobs\Job;

class SendMail extends Job implements ShouldQueue {
	use InteractsWithQueue, SerializesModels;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */

	protected $user_email;
	protected $email_data;
	protected $subject;
	protected $view_name;

	public function __construct($viewname, $subject, $EmailId, $datamsg) {
		$this->user_email = $EmailId;
		$this->email_data = $datamsg;
		$this->subject = $subject;
		$this->view_name = $viewname;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		\MailHelper::sendSyncMail($this->view_name, $this->subject, $this->user_email, $this->email_data);
	}
}
