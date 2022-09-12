<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubheadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subheads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('head_id');
            $table->string('title',50);
            $table->smallInteger('status')->default(1); // 1-Active , 0-Deactive
            $table->decimal('ob',15,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subheads');
    }
}
