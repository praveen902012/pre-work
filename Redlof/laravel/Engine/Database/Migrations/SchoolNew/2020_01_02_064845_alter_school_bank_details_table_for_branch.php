<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSchoolBankDetailsTableForBranch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hastable('school_bank_details')) {
            Schema::table('school_bank_details', function (Blueprint $table) {
                $table->string('ifsc_code', 50)->nullable()->change();
                $table->string('branch', 50)->nullable();
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