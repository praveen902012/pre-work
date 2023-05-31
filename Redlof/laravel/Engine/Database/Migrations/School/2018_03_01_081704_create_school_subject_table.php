<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolSubjectTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('school_subjects')) {
			Schema::create('school_subjects', function (Blueprint $table) {

				$table->bigIncrements('id');

				$table->bigInteger('subject_id')->unsigned();
				$table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

				$table->bigInteger('level_id')->unsigned();
				$table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');

				$table->bigInteger('schooladmin_id')->unsigned();
				$table->foreign('schooladmin_id')->references('id')->on('users')->onDelete('cascade');

				$table->bigInteger('school_id')->unsigned();
				$table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');

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
		Schema::drop('school_subjects');
	}
}
