<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IAddColumnToBankTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_transactions', function (Blueprint $table) {
            $table->Integer('supinvid')->default(0);
            $table->Integer('cusinvid')->default(0);
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
