<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationParentDetails extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('registration_parent_details')) {
			Schema::create('registration_parent_details', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('registration_id')->unsigned();
				$table->foreign('registration_id')->references('id')->on('registration_basic_details')->onDelete('cascade');

				$table->enum('parent_type', ['father', 'mother', 'guardian']);

				$table->string('parent_name', 150);
				$table->string('parent_mobile_no', 10);
				$table->string('parent_profession', 100);

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
		Schema::drop('registration_parent_details');
	}
}
