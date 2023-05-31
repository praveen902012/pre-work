<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hastable('school_cycles')) {
            Schema::create('school_cycles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('school_id')->unsigned();
                $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
                $table->bigInteger('application_cycle_id')->unsigned();
                $table->foreign('application_cycle_id')->references('id')->on('application_cycles')->onDelete('cascade');
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
    public function down()
    {
        Schema::dropIfExists('school_cycles');
    }
}
