<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateSubjectTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('state_subjects')) {
			Schema::create('state_subjects', function (Blueprint $table) {

				$table->bigIncrements('id');

				$table->bigInteger('subject_id')->unsigned();
				$table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

				$table->bigInteger('level_id')->unsigned();
				$table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');

				$table->bigInteger('stateadmin_id')->unsigned();
				$table->foreign('stateadmin_id')->references('id')->on('users')->onDelete('cascade');

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
		Schema::drop('state_subjects');
	}
}