<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblmanHeadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblmanhead', function (Blueprint $table) {
            $table->id();
            $table->smallinteger('mheadId')->unique();
            $table->string('mheadname',75);
            $table->string('sstatus',15)->nullable();
            $table->boolean('mdbtnature');
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
        Schema::dropIfExists('tblmanhead');
    }
}
