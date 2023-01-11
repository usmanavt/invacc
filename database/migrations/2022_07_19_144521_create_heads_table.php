<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heads', function (Blueprint $table) {
            $table->id();
            $table->string('title',75);
            $table->smallInteger('nature')->default(0);
            $table->smallInteger('status')->default(1); // 1-Active , 0-Deactive
            $table->smallInteger('forcr')->default(0);
            $table->smallInteger('forcp')->default(0);
            $table->smallInteger('forbr')->default(0);
            $table->smallInteger('forbp')->default(0);
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
        Schema::dropIfExists('heads');
    }
}
