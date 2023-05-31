<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportCardsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('report_cards')) {
			Schema::create('report_cards', function (Blueprint $table) {

				$table->bigIncrements('id');

				$table->bigInteger('school_id')->unsigned();
				$table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');

				$table->smallInteger('application_year');

				$table->bigInteger('level_id')->unsigned();
				$table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');

				$table->smallInteger('year')->nullable();

				$table->integer('tution_payable')->nullable();

				$table->integer('amount_payable')->nullable();

				$table->integer('other_payable')->nullable();

				$table->enum('status', ['active', 'inactive'])->default('active');

				$table->enum('payment_status', ['paid', 'not_paid', 'not_received'])->default('not_paid');

				$table->enum('tution_fee_status', ['paid', 'not_paid', 'not_received'])->default('not_paid');

				$table->enum('other_fee_status', ['paid', 'not_paid', 'not_received'])->default('not_paid');

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
		Schema::drop('report_cards');
	}
}
