<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbleobszwsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbleobszws', function (Blueprint $table) {
            $table->id();
            $table->smallinteger('itmid0');
            $table->smallinteger('itmid');
            $table->smallinteger('itmsizeid');
            $table->integer('obqty')->nullable();
            $table->decimal('purrate',10,2)->nullable();
            $table->decimal('costrate',10,2)->nullable();
            $table->smallinteger('srcid');
            $table->smallinteger('purunitid');
            $table->integer('trid')->unique();
            $table->smallinteger('locid');
            $table->smallinteger('brandid');
            $table->string('sstatus',12);
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
        Schema::dropIfExists('tbleobszws');
    }
}
