<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubLocalitiesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('sub_localities')) {
			Schema::create('sub_localities', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('locality_id')->unsigned();
				$table->foreign('locality_id')->references('id')->on('localities')->onDelete('cascade');

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
		Schema::drop('sub_localities');
	}

}