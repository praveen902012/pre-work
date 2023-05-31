<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAllotmentStatasticsForApplicationCycle extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hastable('allottment_statistics')) {
			Schema::table('allottment_statistics', function (Blueprint $table) {

				$table->bigInteger('application_cycle_id')->unsigned()->nullable();
				$table->foreign('application_cycle_id')->references('id')->on('application_cycles')->onDelete('cascade');

			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		if (Schema::hastable('allottment_statistics')) {
			Schema::table('allottment_statistics', function (Blueprint $table) {
				if (Schema::hasColumn('allottment_statistics', 'application_cycle_id')) {
					$table->dropColumn('application_cycle_id');
				}
			});
		}
	}
}
