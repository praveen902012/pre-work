<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClustersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hastable('clusters')) {
			Schema::create('clusters', function (Blueprint $table) {
				$table->bigIncrements('id');
                $table->bigInteger('block_id')->unsigned();
				$table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
                $table->string('name');
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
        Schema::dropIfExists('clusters');
    }
}
