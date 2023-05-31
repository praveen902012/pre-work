<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRegistrationBasicDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if (Schema::hastable('registration_personal_details')) {
		// 	Schema::table('registration_personal_details', function (Blueprint $table) {
		// 		$table->string('state_type')->nullable();
		// 		$table->bigInteger('sub_block_id')->unsigned()->nullable();
		// 	});
		// }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
