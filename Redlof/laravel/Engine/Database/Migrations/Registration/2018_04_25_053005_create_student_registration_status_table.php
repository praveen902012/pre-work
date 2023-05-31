<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentRegistrationStatusTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('student_registration_status')) {
			Schema::create('student_registration_status', function (Blueprint $table) {

				$table->bigIncrements('id');

				$table->bigInteger('district_id')->unsigned();
				$table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');

				$table->timestamp('closing_date')->nullable();

				$table->enum('status', ['open', 'closed'])->default('open');

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
		Schema::drop('student_registration_status');
	}
}
