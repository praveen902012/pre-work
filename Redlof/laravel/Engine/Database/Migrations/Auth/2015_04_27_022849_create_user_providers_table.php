<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('user_providers')) {
			Schema::create('user_providers', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('user_id')->unsigned();
				$table->foreign('user_id')->references('id')->on('users');
				$table->string('provider');
				$table->string('provider_id');
				$table->string('screen_name')->nullable();
				$table->string('link')->nullable();
				$table->string('access_token', 1000)->nullable();
				$table->string('avatar')->nullable();
				$table->string('oauth_token', 500)->nullable();
				$table->string('oauth_token_secret', 500)->nullable();
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('user_providers', function (Blueprint $table) {
			$table->dropForeign('user_providers_user_id_foreign');
		});
		Schema::drop('user_providers');
	}

}
