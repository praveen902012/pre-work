<?php

namespace Redlof\Core\Commands;

use Illuminate\Console\Command;

class MigrateAll extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'redlof:migrate-all';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Migrate All migrations present in the codebase';

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
		// Loop through all the folders inside engine
		// copy each of the files into a new directory
		// run migration in the directory

		$EnginePath = "Redlof/laravel/Engine/Database/Migrations";
		$tempPath = 'storage/redlof/migrations';

		$scanned_directory = array_diff(scandir($EnginePath), array('..', '.'));

		// Create the temporary directories
		if (FALSE == is_dir($tempPath)) {
			mkdir($tempPath, 0777, true);
		}

		foreach ($scanned_directory as $key => $ModuleName) {

			$ModulePath = $EnginePath . '/' . $ModuleName . '/';
			$MigrationsPath = $ModulePath; //.'Database/Migrations';

			if (FALSE == is_dir($ModulePath)) {
				continue;
			}

			// Check if migration folder is present
			if (FALSE == file_exists($MigrationsPath)) {
				continue;
			}

			// All file in the directory
			$Files = array_diff(scandir($MigrationsPath), array('..', '.'));

			foreach ($Files as $key => $fileName) {

				if (FALSE == is_file($MigrationsPath . '/' . $fileName)) {
					continue;
				}

				copy($MigrationsPath . '/' . $fileName, $tempPath . '/' . $fileName);
			}

			$this->info('Migration - ' . $ModuleName);
		}

		$this->call('migrate', ['--path' => $tempPath]);

		$this->cleanTempFolder();
	}

	private function cleanTempFolder() {
		$tempPath = 'storage/redlof/migrations';

		$Files = array_diff(scandir($tempPath), array('..', '.'));

		foreach ($Files as $key => $value) {
			unlink($tempPath . '/' . $value);
		}
	}
}
