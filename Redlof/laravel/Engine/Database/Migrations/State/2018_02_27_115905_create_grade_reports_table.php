<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeReportsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('grade_reports')) {
			Schema::create('grade_reports', function (Blueprint $table) {

				$table->bigIncrements('id');

				$table->bigInteger('report_id')->unsigned();
				$table->foreign('report_id')->references('id')->on('report_cards')->onDelete('cascade');

				$table->bigInteger('subject_id')->unsigned();
				$table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

				$table->integer('total_marks');

				$table->integer('scored_marks');

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
		Schema::drop('grade_reports');
	}
}
