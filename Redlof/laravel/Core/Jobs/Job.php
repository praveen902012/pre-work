<?php

namespace Redlof\Core\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Job implements ShouldQueue {
	use InteractsWithQueue, Queueable, SerializesModels;

	public function __construct() {

	}

	public function handle() {

	}

}