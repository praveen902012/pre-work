<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceReportsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('attendance_reports')) {
			Schema::create('attendance_reports', function (Blueprint $table) {

				$table->bigIncrements('id');

				$table->bigInteger('report_id')->unsigned();
				$table->foreign('report_id')->references('id')->on('report_cards')->onDelete('cascade');

				$table->string('month');

				$table->integer('total_days');

				$table->integer('attended_days');

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
		Schema::drop('attendance_reports');
	}
}
