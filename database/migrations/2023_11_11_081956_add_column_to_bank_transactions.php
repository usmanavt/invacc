<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToBankTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_transactions', function (Blueprint $table) {
            $table->Integer('transno')->default(0);
            $table->tinyInteger('advance')->default(0);
            $table->tinyInteger('invslvl')->default(0);
            $table->string('supname', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_transactions', function (Blueprint $table) {
            //
        });
    }
}
