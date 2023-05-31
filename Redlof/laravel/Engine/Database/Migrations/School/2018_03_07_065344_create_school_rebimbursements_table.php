<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolRebimbursementsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('school_reimbursements')) {
			Schema::create('school_reimbursements', function (Blueprint $table) {

				$table->bigIncrements('id');

				$table->bigInteger('school_id')->unsigned();
				$table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');

				$table->integer('reimbursement_amount')->nullable();

				$table->enum('payment_status', ['paid', 'not_paid', 'not_received'])->default('not_paid');

				$table->timestamp('payed_on')->nullable();

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
		Schema::drop('school_reimbursements');
	}
}
