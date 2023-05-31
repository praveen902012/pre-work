<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodaladminBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hastable('nodaladmin_blocks')) {
			Schema::create('nodaladmin_blocks', function (Blueprint $table) {
                $table->bigIncrements('id');
                
                $table->bigInteger('block_id')->unsigned();
                $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
                
                $table->bigInteger('state_nodals_id')->unsigned();
				$table->foreign('state_nodals_id')->references('id')->on('state_nodals')->onDelete('cascade');
                 
                $table->string('status')->default('active');
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
        Schema::dropIfExists('nodaladmin_blocks');
    }
}
