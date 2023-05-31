<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemCommunicationsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('system_communications')) {
			Schema::create('system_communications', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('user_id');

				$table->string('email')->nullable();
				$table->string('type');
				$table->jsonb('content')->nullable();

				$table->dateTime('trigger_time')->nullable();
				$table->dateTime('expiry_time')->nullable();

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
		Schema::drop('system_communications');
	}
}
