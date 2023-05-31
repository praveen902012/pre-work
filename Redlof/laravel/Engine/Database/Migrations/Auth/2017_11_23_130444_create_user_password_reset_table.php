<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPasswordResetTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('user_password_resets')) {

			Schema::create('user_password_resets', function (Blueprint $table) {

				$table->bigInteger('user_id')->unsigned();
				$table->foreign('user_id')->references('id')->on('users');

				$table->string('token')->index();

				$table->timestamp('created_at');
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('user_password_resets');
	}
}
