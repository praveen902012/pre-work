<?php

namespace Redlof\Core;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as Kernel;

class ConsoleKernel extends Kernel {
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		Commands\EnvCommand::class,
		Commands\MigrateAll::class,
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule) {

		// $schedule->command('queue:work')->everyMinute();

		$schedule->call(function () {

            \Redlof\Engine\SystemCommunication\PingTo::cron();

        })->everyMinute();
		
		if (env('APP_ENV') == 'production') {
			// $schedule->command('backup:run --only-db')->hourly();
		}

	}

	/**
	 * Register the Closure based commands for the application.
	 *
	 * @return void
	 */
	protected function commands() {
		//require base_path('routes/console.php');
	}
}
