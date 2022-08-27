<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblesmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblesmenu', function (Blueprint $table) {
            $table->id();
            $table->smallinteger('mmenuid');
            $table->string('smenuname',30);
            $table->string('Par1',30);
            $table->string('Par2',30);
            $table->string('Par3',30);
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
        Schema::dropIfExists('tblesmenu');
    }
}
