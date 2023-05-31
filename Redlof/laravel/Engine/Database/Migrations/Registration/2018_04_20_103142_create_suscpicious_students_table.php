<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuscpiciousStudentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('suspicious_students')) {
			Schema::create('suspicious_students', function (Blueprint $table) {

				$table->bigIncrements('id');

				$table->bigInteger('district_id')->unsigned();
				$table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');

				$table->bigInteger('registration_id');
				$table->foreign('registration_id')->references('id')->on('registration_basic_details')->onDelete('cascade');

				$table->bigInteger('schooladmin_id')->unsigned();
				$table->foreign('schooladmin_id')->references('id')->on('school_admins')->onDelete('cascade');

				$table->string('suspicious_reason', 1000)->nullable();

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
		Schema::drop('suspicious_students');
	}
}
