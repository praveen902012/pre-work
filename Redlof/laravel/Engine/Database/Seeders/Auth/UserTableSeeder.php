<?php
namespace Redlof\Engine\Seeds;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		\Schema::disableForeignKeyConstraints();

		$users = [
			[
				'name_title' => null,
				'first_name' => 'Administrator',
				'last_name' => '',
				'email' => 'admin@think201.com',
				'username' => 'admin@think201.com',
				'password' => bcrypt('think'),
				'locale' => '',
				'timezone' => '',
				'photo' => '',
				'gender' => 'm',
				'dob' => '1990-01-01',
				'country_code' => '',
				'phone' => '',
				'confirmation_code' => md5(uniqid(mt_rand(), true)),
				'status' => 'active',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
		];

		DB::table('users')->insert($users);

		\Schema::enableForeignKeyConstraints();
	}

}
