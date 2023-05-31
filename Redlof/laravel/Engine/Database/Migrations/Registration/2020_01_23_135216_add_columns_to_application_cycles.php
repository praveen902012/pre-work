<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToApplicationCycles extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::table('application_cycles', function (Blueprint $table) {

			if (!Schema::hasColumn('application_cycles', 'stu_reg_start_date')) {
				$table->dateTime('stu_reg_start_date')->nullable();
			}
			
			if (!Schema::hasColumn('application_cycles', 'stu_reg_end_date')) {
				$table->dateTime('stu_reg_end_date')->nullable();
			}

		});

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
