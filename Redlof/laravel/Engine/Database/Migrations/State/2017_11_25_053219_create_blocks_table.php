<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('blocks')) {
			Schema::create('blocks', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('name')->unique();

				$table->bigInteger('district_id')->unsigned();
				$table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');

			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('blocks');
	}

}