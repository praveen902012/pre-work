<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSchoolLevelInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (Schema::hastable('school_level_infos')) {
			Schema::table('school_level_infos', function (Blueprint $table) {

				$table->bigInteger('application_cycle_id')->unsigned()->nullable();
				$table->foreign('application_cycle_id')->references('id')->on('application_cycles')->onDelete('cascade');

			});
		}
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
