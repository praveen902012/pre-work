<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolAdminsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('school_admins')) {
			Schema::create('school_admins', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('school_id')->unsigned();
				$table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
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
		Schema::drop('school_admins');
	}
}
