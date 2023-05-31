<?php
namespace Redlof\Engine\Seeds;
use Illuminate\Database\Seeder;

class LevelTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		\Schema::disableForeignKeyConstraints();

		$levels = [
			[
				'level' => 'Nursery',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'level' => 'KG 1',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'level' => 'KG 2',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'level' => 'Class 1',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'level' => 'Class 2',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'level' => 'Class 3',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'level' => 'Class 4',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'level' => 'Class 5',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'level' => 'Class 6',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'level' => 'Class 7',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'level' => 'Class 8',
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
		];

		\DB::table('levels')->insert($levels);

		\Schema::enableForeignKeyConstraints();
	}

}
