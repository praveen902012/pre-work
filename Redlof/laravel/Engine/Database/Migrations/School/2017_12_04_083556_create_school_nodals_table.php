<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolNodalsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('school_nodals')) {
			Schema::create('school_nodals', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('school_id')->unsigned();
				$table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');

				$table->bigInteger('nodal_id')->unsigned();
				$table->foreign('nodal_id')->references('id')->on('state_nodals')->onDelete('cascade');

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
		Schema::drop('school_nodals');
	}
}
