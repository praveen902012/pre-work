<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		//
		if (!Schema::hastable('regions')) {
			Schema::create('regions', function (Blueprint $table) {
				$table->bigIncrements('id');
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
		//
		Schema::drop('regions');
	}
}
