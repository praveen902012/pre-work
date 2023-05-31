<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubSubLocalitiesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('sub_sub_localities')) {
			Schema::create('sub_sub_localities', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('sub_locality_id')->unsigned();
				$table->foreign('sub_locality_id')->references('id')->on('sub_localities')->onDelete('cascade');

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
		Schema::drop('sub_sub_localities');
	}

}