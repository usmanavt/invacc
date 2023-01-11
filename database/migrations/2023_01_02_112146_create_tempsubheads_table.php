<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempsubheadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempsubheads', function (Blueprint $table) {
            $table->id();
            $table->smallinteger('head_id');
            $table->string('title',50);
            $table->smallInteger('status')->default(1); // 1-Active , 0-Deactive


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tempsubheads');
    }
}
