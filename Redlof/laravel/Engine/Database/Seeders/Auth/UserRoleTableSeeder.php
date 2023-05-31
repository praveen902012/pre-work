<?php
namespace Redlof\Engine\Seeds;
use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\Schema::disableForeignKeyConstraints();

		$role_user = [
			[
				'user_id' => 1,
				'role_id' => 1,
			],

		];

		\DB::table('role_user')->insert($role_user);
		\Schema::enableForeignKeyConstraints();
	}

}
