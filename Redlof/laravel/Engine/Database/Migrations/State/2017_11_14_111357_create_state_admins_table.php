<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateAdminsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('state_admins')) {
			Schema::create('state_admins', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->enum('status', ['active', 'inactive'])->default('active');
				$table->bigInteger('state_id')->unsigned();
				$table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
				$table->bigInteger('user_id')->unsigned();
				$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('state_admins');
	}
}
