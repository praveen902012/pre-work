<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolLevelInfosTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('school_level_infos')) {
			Schema::create('school_level_infos', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->integer('total_fee')->nullable();
				$table->integer('tution_fee')->nullable();
				$table->integer('other_fee')->nullable();
				$table->integer('available_seats')->nullable();
				$table->bigInteger('school_id')->unsigned();
				$table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
				$table->bigInteger('level_id')->unsigned();
				$table->foreign('level_id')->references('id')->on('school_levels')->onDelete('cascade');
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
		Schema::drop('school_level_infos');
	}
}
