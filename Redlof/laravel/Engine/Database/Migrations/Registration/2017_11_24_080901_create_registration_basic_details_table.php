<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationBasicDetailsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('registration_basic_details')) {
			Schema::create('registration_basic_details', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('state_id')->unsigned();
				$table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');

				$table->string('registration_no')->unique();
				$table->string('guid')->unique();

				$table->string('first_name');
				$table->string('middle_name')->nullable();
				$table->string('last_name');

				$table->enum('gender', ['male', 'female', 'transgender', 'not_defined'])->default('not_defined');
				$table->date('dob');
				// $table->enum('birth_proof', ['birth_ceritificate', 'aadhaar'])->nullable();
				$table->string('mobile', 10);
				$table->string('email', 150)->nullable();

				$table->bigInteger('level_id')->unsigned();
				$table->foreign('level_id')->references('id')->on('states')->onDelete('cascade');

				$table->string('aadhar_no', 50)->nullable();
				$table->string('aadhar_enrollment_no', 50)->nullable();

				$table->enum('status', ['active', 'completed', 'inactive'])->default('active');
				$table->enum('state', ['step1', 'step2', 'step3', 'step4', 'step5'])->default('step2');
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
		Schema::drop('registration_basic_details');
	}
}
