<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRegistrationPersonalTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hastable('registration_personal_details')) {
			Schema::table('registration_personal_details', function (Blueprint $table) {
				$table->float('lat', 10, 6)->nullable();
				$table->float('lng', 10, 6)->nullable();
				$table->string('venue')->nullable();

			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
	}
}
