<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserConfigTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('user_config')) {
			Schema::create('user_config', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('user_id');
				$table->string('data', 5000);
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
		Schema::drop('user_config');
	}
}
