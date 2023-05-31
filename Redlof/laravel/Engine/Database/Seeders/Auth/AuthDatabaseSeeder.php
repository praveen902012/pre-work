<?php

use Illuminate\Database\Seeder;

class AuthDatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$this->call(\Redlof\Engine\Seeds\RoleTableSeeder::class);
		$this->call(\Redlof\Engine\Seeds\UserTableSeeder::class);
		$this->call(\Redlof\Engine\Seeds\UserRoleTableSeeder::class);
		$this->call(\Redlof\Engine\Seeds\LevelTableSeeder::class);
		$this->call(\Redlof\Engine\Seeds\StateTableSeeder::class);
	}
}
