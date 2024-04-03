<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrmrptparamtrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frmrptparamtrs', function (Blueprint $table) {
            $table->id();
            $table->string('mytitle', 50)->nullable();
            $table->tinyInteger('rptid')->default(0);
            $table->string('rptname', 30)->nullable();
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
        Schema::dropIfExists('frmrptparamtrs');
    }
}
