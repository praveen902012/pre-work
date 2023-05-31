<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationCycles extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		//
		if (!Schema::hastable('application_cycles')) {
			Schema::create('application_cycles', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('state_id')->unsigned();
				$table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');

				$table->dateTime('reg_start_date');
				$table->dateTime('reg_end_date')->nullable();
				$table->dateTime('lottery_announcement');
				$table->dateTime('enrollment_end_date');

				$table->smallInteger('session_year');
				$table->smallInteger('cycle')->default(1);
				$table->enum('trigger_type', ['auto', 'manual'])
					->default('auto');
				$table->enum('status', ['new', 'completed', 'paused'])
					->default('new');
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
		Schema::drop('application_cycles');
	}
}
