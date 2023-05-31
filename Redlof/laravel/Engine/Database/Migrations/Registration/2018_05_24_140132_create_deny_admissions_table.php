<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenyAdmissionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('deny_admissions')) {
			Schema::create('deny_admissions', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('registration_id')->unsigned();

				$table->foreign('registration_id')->references('id')->on('registration_basic_details')->onDelete('cascade');

				$table->enum('status', ['active', 'inactive'])->default('active');

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
		//
	}
}
