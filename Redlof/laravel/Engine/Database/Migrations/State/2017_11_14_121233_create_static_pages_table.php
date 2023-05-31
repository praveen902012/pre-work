<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPagesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('static_pages')) {
			Schema::create('static_pages', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('state_id')->unsigned();
				$table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');

				$table->bigInteger('user_id')->unsigned();
				$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
				
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
		Schema::drop('static_pages');
	}
}
