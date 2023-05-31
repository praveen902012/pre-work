<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRegistrationBasicDetailsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		//
		if (Schema::hastable('registration_basic_details')) {
			Schema::table('registration_basic_details', function (Blueprint $table) {
				$table->dropForeign('registration_basic_details_level_id_foreign');

			});

			Schema::table('registration_basic_details', function (Blueprint $table) {
				$table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');

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
