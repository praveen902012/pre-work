<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationCyclesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('registration_cycles')) {
			Schema::create('registration_cycles', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('registration_id')->unsigned();
				$table->foreign('registration_id')->references('id')->on('registration_basic_details')->onDelete('cascade');

				$table->jsonb('preferences');
				$table->integer('cycle')->default(1);

				$table->enum('status', ['applied', 'allotted', 'enrolled', 'dismissed', 'rejected', 'withdraw', 'dropout'])->default('applied');
				$table->bigInteger('allotted_school_id')->unsigned()->nullable();
				$table->foreign('allotted_school_id')->references('id')->on('schools')->onDelete('cascade');
				$table->bigInteger('application_cycle_id')->unsigned()->nullable();
				$table->foreign('application_cycle_id')->references('id')->on('application_cycles')->onDelete('cascade');

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
	}
}
