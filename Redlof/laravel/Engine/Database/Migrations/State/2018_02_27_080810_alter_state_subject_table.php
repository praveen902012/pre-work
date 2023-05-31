<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStateSubjectTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hastable('state_subjects')) {
			Schema::table('state_subjects', function (Blueprint $table) {

				$table->bigInteger('state_id')->unsigned();
				$table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');

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
