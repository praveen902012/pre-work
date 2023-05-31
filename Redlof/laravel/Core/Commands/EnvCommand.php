<?php

namespace Redlof\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class EnvCommand extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'env:switch';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Switch between environments by changing .env file';

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
		// Get the env file path
		$envPath = base_path() . '/.env';

		// Get the current env
		$envir = $this->laravel['env'];

		if ($this->option('save')) {
			// save current env
			$targetPath = base_path() . '/.' . $envir . '.env';
			File::put($targetPath, File::get($envPath), true);
			$this->info('Environmental config file <comment>.' . $envir . '.env</comment> saved');
		} else {
			// switch to a different env
			$targetEnv = $this->argument('env');
			$targetPath = base_path() . '/.' . $targetEnv . '.env';

			if (!File::exists($targetPath)) {
				$this->error('Cannot switch to environment:<info> ' . $targetEnv . ' </info>because<info> .' . $targetEnv . '.env </info>doesn\'t exist');
				return;
			}

			File::put($envPath, File::get($targetPath), true);
			$this->info('Successfully switched from <comment>' . $envir . '</comment> to <comment>' . $targetEnv . '</comment>.');
		}
	}
}