<?php
namespace Redlof\Engine\Seeds;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		\DB::table('roles')->truncate();

		$roles = [
			[
				'id' => 1,
				'name' => 'role-admin',
				'display_name' => 'Admin',
				'description' => '',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'id' => 2,
				'name' => 'role-state-admin',
				'display_name' => 'State Admin',
				'description' => '',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'id' => 3,
				'name' => 'role-district-admin',
				'display_name' => 'District Admin',
				'description' => '',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'id' => 4,
				'name' => 'role-nodal-admin',
				'display_name' => 'Nodal Admin',
				'description' => '',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'id' => 5,
				'name' => 'role-school-admin',
				'display_name' => 'School Admin',
				'description' => '',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
		];

		\DB::table('roles')->insert($roles);
	}

}
