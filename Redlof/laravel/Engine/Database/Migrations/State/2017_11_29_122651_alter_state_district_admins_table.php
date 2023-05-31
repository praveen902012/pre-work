<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStateDistrictAdminsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hastable('state_district_admins')) {
			Schema::table('state_district_admins', function (Blueprint $table) {

				$table->bigInteger('district_id')->unsigned()->nullable();
				$table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');

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
