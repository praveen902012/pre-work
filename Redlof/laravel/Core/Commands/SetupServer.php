<?php

namespace Redlof\Core\Commands;

use Illuminate\Console\Command;

class SetupServer extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'redlof:setup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Set up server';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {

		// This command, should set up the server or the working directory
		// Create Storage folder & all folders inside
		// Give permission to Storage folder
		// Give permission to bootstrap/cache folder

		$app = "storage/app/public";

		mkdir($app, 0777, true);

		$fCache = "storage/framework/cache";
		$fSessions = "storage/framework/sessions";
		$fViews = "storage/framework/views";

		mkdir($fCache, 0777, true);
		mkdir($fSessions, 0777, true);
		mkdir($fViews, 0777, true);

		$logs = "storage/logs";

		mkdir($logs, 0777, true);
	}
}
