<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsLatestColumnToApplicationCycles extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::table('application_cycles', function (Blueprint $table) {

			if (!Schema::hasColumn('application_cycles', 'is_latest')) {
				
				$table->boolean('is_latest')->default(FALSE);
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
