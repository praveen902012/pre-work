<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationBankDetailTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('registration_bank_details')) {
			Schema::create('registration_bank_details', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('registration_id')->unsigned();
				$table->foreign('registration_id')->references('id')->on('registration_basic_details')->onDelete('cascade');

				$table->string('account_number', 50);
				$table->string('account_holder_name');
				$table->string('bank_name');
				$table->string('ifsc_code', 50);
				$table->string('misc', 5000)->nullable();

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
		Schema::drop('registration_bank_details');
	}
}
