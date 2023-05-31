<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllotmentHistoryTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		//
		if (!Schema::hastable('allotment_histories')) {
			Schema::create('allotment_histories', function (Blueprint $table) {

				$table->bigIncrements('id');
				$table->bigInteger('state_id')->unsigned()->nullable();
				$table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
				$table->jsonb('alloted_student_reg_id')->nullable();
				$table->jsonb('total_student_reg_id')->nullable();
				$table->string('message')->nullable();
				$table->smallInteger('year')->nullable();
				$table->jsonb('metadata')->nullable();

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
		Schema::drop('allotment_histories');
	}
}
