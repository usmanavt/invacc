<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblsubheadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblsubhead', function (Blueprint $table) {
            $table->id();
            $table->smallinteger('mheadid');
            $table->smallinteger('subheadid')->unique();
            $table->string('subheadname',100);
            $table->string('sstatus',15);
            $table->integer('ob')->nullable();
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
        Schema::dropIfExists('tblsubhead');
    }
}
