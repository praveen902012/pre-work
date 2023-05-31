<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUdiseNodalsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		//
		if (!Schema::hastable('udisenodals')) {
			Schema::create('udisenodals', function (Blueprint $table) {

				$table->bigIncrements('id');

				$table->bigInteger('district_id')->unsigned();
				$table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');

				$table->string('email', 150);

				$table->string('udise');

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
		Schema::drop('udisenodals');
	}
}
