<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSchoolsTableForClusters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hastable('schools')) {
            Schema::table('schools', function (Blueprint $table) {
                $table->bigInteger('cluster_id')->unsigned()->nullable();
				$table->foreign('cluster_id')->references('id')->on('clusters')->onDelete('cascade');
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
