<?php
namespace Redlof\Core\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessages implements ShouldQueue {
	use InteractsWithQueue, Queueable, SerializesModels, Dispatchable;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */

	protected $students;
	protected $message;

	public function __construct($students, $message) {
		$this->students = $students;
		$this->message = $message;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {

		$all_students = $this->students;
		$message = $this->message;

		foreach ($all_students as $key => $student) {

			$custom_message = '';

			$custom_message = 'Bachche kaa naam: ' . $student['first_name'] . ' ' . $student['last_name'] . '%0aRegistration Number: ' . $student['registration_no'] . '%0aAllotted School: ' . $student['registration_cycle']['school']['name'] . '%0a%0a' . $message;

			$input['message'] = $custom_message;

			$input['phone'] = $student['mobile'];

			\MsgHelper::sendSyncSMS($input);

		}

		return true;
	}
}
