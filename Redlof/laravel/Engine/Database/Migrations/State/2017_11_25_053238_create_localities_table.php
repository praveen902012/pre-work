<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalitiesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('localities')) {
			Schema::create('localities', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('block_id')->unsigned();
				$table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');

				$table->string('name')->unique();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('localities');
	}

}