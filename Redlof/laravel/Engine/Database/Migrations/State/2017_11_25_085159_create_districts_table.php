<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('districts')) {
			Schema::create('districts', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('state_id')->unsigned();
				$table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');

				$table->string('name');

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
		Schema::drop('districts');
	}

}