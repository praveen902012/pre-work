<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolGrievancesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('school_grievances')) {
			Schema::create('school_grievances', function (Blueprint $table) {

				$table->bigIncrements('id');

				$table->bigInteger('district_id')->unsigned();
				$table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');

				$table->string('registration_no');
				$table->foreign('registration_no')->references('registration_no')->on('registration_basic_details')->onDelete('cascade');

				$table->string('school_name');

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
		Schema::drop('school_grievances');
	}
}
