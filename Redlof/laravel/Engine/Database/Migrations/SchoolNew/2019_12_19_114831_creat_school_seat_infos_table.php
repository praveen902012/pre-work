<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatSchoolSeatInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hastable('school_seat_infos')) {
            Schema::create('school_seat_infos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('school_id')->unsigned();
                $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
                $table->bigInteger('level_id')->unsigned();
                $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
                $table->string('year')->nullable();
                $table->string('total_seats')->nullable();
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
        //
    }
}
