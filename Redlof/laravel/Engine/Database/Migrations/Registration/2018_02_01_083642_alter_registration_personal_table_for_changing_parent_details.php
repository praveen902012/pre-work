<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRegistrationPersonalTableForChangingParentDetails extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hastable('registration_personal_details')) {
			Schema::table('registration_personal_details', function (Blueprint $table) {
				$table->dropColumn(['parent_type', 'parent_name', 'parent_mobile_no', 'parent_profession', 'parent_id_proof']);
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
	}
}
