<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FAddColumnToGatepasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gatepasses', function (Blueprint $table) {

            $table->string('drvrname', 50)->nullable();
            $table->string('drvrtelno', 20)->nullable();
            $table->string('vehno', 20)->nullable();
            $table->string('deptime', 8)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gatepasses', function (Blueprint $table) {
            //
        });
    }
}
