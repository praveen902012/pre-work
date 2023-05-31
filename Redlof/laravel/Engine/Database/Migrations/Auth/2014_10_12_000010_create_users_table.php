<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('users')) {
			Schema::create('users', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('name_title', 5)->nullable();
				$table->string('first_name');
				$table->string('last_name');
				$table->string('username')->unique();
				$table->string('email')->unique();
				$table->string('country_code', 3)->nullable();
				$table->string('phone')->nullable();
				$table->string('password', 60);
				$table->string('photo')->nullable();
				$table->string('locale')->nullable();
				$table->string('timezone')->nullable();
				$table->enum('gender', ['m', 'f', 'u'])->nullable()->default('u');
				$table->date('dob')->nullable();
				$table->enum('status', ['active', 'inactive']);
				$table->string('confirmation_code');
				$table->boolean('confirmed')->default(true);
				$table->rememberToken();
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
		Schema::drop('users');
	}
}
