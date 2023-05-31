<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('states')) {
			Schema::create('states', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('name');
				$table->string('slug');
				$table->string('logo')->nullable();
				$table->jsonb('documents')->nullable();

				$table->bigInteger('language_id')->unsigned()->nullable();
				$table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');

				$table->enum('status', ['active', 'inactive'])->default('inactive');

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
		Schema::drop('states');

	}
}
