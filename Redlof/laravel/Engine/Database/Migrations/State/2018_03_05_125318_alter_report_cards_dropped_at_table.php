<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterReportCardsDroppedAtTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hastable('report_cards')) {
			Schema::table('report_cards', function (Blueprint $table) {

				$table->enum('student_status', ['regular', 'dropped'])->default('regular');

				$table->timestamp('dropped_at')->nullable();

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
