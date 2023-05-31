<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationPersonalDetailsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hastable('registration_personal_details')) {
			Schema::create('registration_personal_details', function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->bigInteger('registration_id')->unsigned();
				$table->foreign('registration_id')->references('id')->on('registration_basic_details')->onDelete('cascade');

				$table->enum('category', ['bpl', 'dg']);
				$table->jsonb('certificate_details');
				$table->enum('parent_type', ['father', 'mother', 'guardian']);

				$table->string('parent_name', 150);
				$table->string('parent_mobile_no', 10);
				$table->string('parent_id_proof', 50);
				$table->string('parent_profession', 100);

				$table->string('residential_address', 300)->nullable();

				$table->bigInteger('district_id')->unsigned()->nullable();
				$table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');

				$table->bigInteger('locality_id')->unsigned()->nullable();
				$table->foreign('locality_id')->references('id')->on('localities')->onDelete('cascade');

				$table->bigInteger('sub_locality_id')->unsigned()->nullable();
				$table->foreign('sub_locality_id')->references('id')->on('sub_localities')->onDelete('cascade');

				$table->bigInteger('sub_sub_locality_id')->unsigned()->nullable();
				$table->foreign('sub_sub_locality_id')->references('id')->on('sub_sub_localities')->onDelete('cascade');

				$table->bigInteger('block_id')->unsigned()->nullable();
				$table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');

				$table->string('address_proof')->nullable();

				$table->integer('pincode')->nullable();

				$table->jsonb('files')->nullable();

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
		Schema::drop('registration_personal_details');
	}
}
