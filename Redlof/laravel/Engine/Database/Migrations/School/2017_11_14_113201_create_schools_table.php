<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		if (!Schema::hastable('schools')) {
			Schema::create('schools', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('name');
				$table->string('logo')->nullable();
				$table->string('udise');

				$table->bigInteger('language_id')->unsigned();
				$table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');

				$table->string('eshtablished')->nullable();
				$table->string('phone');
				$table->string('website')->nullable();
				$table->string('address', 1000)->nullable();

				$table->bigInteger('state_id')->unsigned()->nullable();
				$table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');

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

				$table->float('lat', 10, 6)->nullable();
				$table->float('lng', 10, 6)->nullable();
				$table->integer('pincode')->nullable();
				$table->string('max_fees')->nullable();
				$table->enum('status', ['active', 'inactive', 'ban'])->default('active');
				$table->enum('application_status', ['applied', 'verified', 'rejected', 'registered', 'recheck'])->default('applied');

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
		Schema::drop('schools');
	}
}
