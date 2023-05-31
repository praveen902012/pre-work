<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('documents')) {
			Schema::create('documents', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->string('title',255)->nullable();
				$table->text('description', 1000)->nullable();
				$table->string('doc');
				$table->string('doc_image');
				
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
		Schema::drop('documents');
	}
}
