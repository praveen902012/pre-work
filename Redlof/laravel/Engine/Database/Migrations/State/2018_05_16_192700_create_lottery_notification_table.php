<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotteryNotificationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		if (!Schema::hastable('lottery_notifications')) {
			Schema::create('lottery_notifications', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->enum('status', ['sent', 'not_sent'])->default('not_sent');
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
		Schema::drop('lottery_notifications');

	}
}
