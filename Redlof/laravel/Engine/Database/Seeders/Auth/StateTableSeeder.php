<?php
namespace Redlof\Engine\Seeds;

use Illuminate\Database\Seeder;

class StateTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		\Schema::disableForeignKeyConstraints();

		$states = [
			[
				'id' => 1,
				'name' => 'Andra Pradesh',
				'slug' => str_slug('Arunachal Pradesh'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'id' => 2,
				'name' => 'Arunachal Pradesh',
				'slug' => str_slug('Arunachal Pradesh'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'id' => 3,
				'name' => 'Punjab',
				'slug' => str_slug('Punjab'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 4,
				'name' => 'Bihar',
				'slug' => str_slug('Bihar'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 5,
				'name' => 'Goa',
				'slug' => str_slug('Goa'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 6,
				'name' => 'Gujarat',
				'slug' => str_slug('Gujarat'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 7,
				'name' => 'Haryana',
				'slug' => str_slug('Haryana'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 8,
				'name' => 'Himachal Pradesh',
				'slug' => str_slug('Himachal Pradesh'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 9,
				'name' => 'Jammu & Kashmir',
				'slug' => str_slug('Jammu & Kashmir'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 10,
				'name' => 'Karnataka',
				'slug' => str_slug('Karnataka'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 11,
				'name' => 'Kerala',
				'slug' => str_slug('Kerala'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 12,
				'name' => 'Madhya Pradesh',
				'slug' => str_slug('Madhya Pradesh'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 13,
				'name' => 'Maharashtra',
				'slug' => str_slug('Maharashtra'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 14,
				'name' => 'Manipur',
				'slug' => str_slug('Manipur'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 15,
				'name' => 'Meghalaya',
				'slug' => str_slug('Meghalaya'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 16,
				'name' => 'Mizoram',
				'slug' => str_slug('Mizoram'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 17,
				'name' => 'Nagaland',
				'slug' => str_slug('Nagaland'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 18,
				'name' => 'Orissa',
				'slug' => str_slug('Orissa'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 19,
				'name' => 'Assam',
				'slug' => str_slug('Assam'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 20,
				'name' => 'Rajasthan',
				'slug' => str_slug('Rajasthan'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 21,
				'name' => 'Sikkim',
				'slug' => str_slug('Sikkim'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 22,
				'name' => 'Tamil Nadu',
				'slug' => str_slug('Tamil Nadu'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 23,
				'name' => 'Tripura',
				'slug' => str_slug('Tripura'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 24,
				'name' => 'Uttar Pradesh',
				'slug' => str_slug('Uttar Pradesh'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 25,
				'name' => 'West Bengal',
				'slug' => str_slug('West Bengal'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 26,
				'name' => 'Chhattisgarh',
				'slug' => str_slug('Chhattisgarh'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 27,
				'name' => 'Uttarakhand',
				'slug' => str_slug('Uttarakhand'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 28,
				'name' => 'Jharkhand',
				'slug' => str_slug('Jharkhand'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 29,
				'name' => 'Telangana',
				'slug' => str_slug('Telangana'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'id' => 30,
				'name' => 'Andaman and Nicobar ',
				'slug' => str_slug('Andaman and Nicobar '),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'id' => 31,
				'name' => 'Chandigarh',
				'slug' => str_slug('Chandigarh'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'id' => 32,
				'name' => 'Dadar and Nagar Haveli',
				'slug' => str_slug('Dadar and Nagar Haveli'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],
			[
				'id' => 33,
				'name' => 'Daman and Diu',
				'slug' => str_slug('Daman and Diu'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 34,
				'name' => 'Delhi',
				'slug' => str_slug('Delhi'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 35,
				'name' => 'Lakshadweep',
				'slug' => str_slug('Lakshadweep'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			], [
				'id' => 36,
				'name' => 'Puducherry',
				'slug' => str_slug('Puducherry'),
				'created_at' => \Carbon::now(),
				'updated_at' => \Carbon::now(),
			],

		];

		\DB::table('states')->insert($states);

		\Schema::enableForeignKeyConstraints();
	}

}
