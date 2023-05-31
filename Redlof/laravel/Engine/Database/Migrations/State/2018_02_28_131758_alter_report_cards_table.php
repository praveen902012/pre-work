<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterReportCardsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hastable('report_cards')) {
			Schema::table('report_cards', function (Blueprint $table) {

				$table->bigInteger('registration_id')->unsigned();
				$table->foreign('registration_id')->references('id')->on('registration_basic_details')->onDelete('cascade');

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
