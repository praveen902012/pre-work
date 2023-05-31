<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTempData extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('user_temp_data')) {
			Schema::create('user_temp_data', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('user_id');
				$table->foreign('user_id')->references('id')->on('registration_basic_details');
				$table->json('data')->nullable();
				$table->timestamps();
				$table->softDeletes();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('user_temp_data');
	}

}