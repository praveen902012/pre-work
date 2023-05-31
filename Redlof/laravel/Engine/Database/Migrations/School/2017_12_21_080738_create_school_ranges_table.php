<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolRangesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('school_ranges')) {
			Schema::create('school_ranges', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('school_id')->unsigned();
				$table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');

				$table->enum('range', ['0-1', '1-3', '3-6', 'beyond_6']);

				$table->enum('type', ['district', 'block', 'locality', 'sublocality'])->default('district');

				$table->jsonb('regions');

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
		Schema::drop('school_ranges');
	}
}
