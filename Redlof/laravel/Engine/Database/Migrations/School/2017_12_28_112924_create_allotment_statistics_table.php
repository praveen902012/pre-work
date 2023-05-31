<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllotmentStatisticsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		//
		if (!Schema::hastable('allottment_statistics')) {
			Schema::create('allottment_statistics', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('school_id')->unsigned()->nullable();
				$table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
				$table->bigInteger('level_id')->unsigned()->nullable();
				$table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
				$table->smallInteger('allotted_seats')->default(1);
				$table->smallInteger('year');

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
		//
		Schema::drop('allottment_statistics');
	}
}
