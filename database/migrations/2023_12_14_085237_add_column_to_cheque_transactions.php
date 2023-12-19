<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToChequeTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cheque_transactions', function (Blueprint $table) {
            $table->string('banknaration', 50)->nullable();
            $table->Integer('crdtcust')->default(0);
            $table->Integer('invsclrd')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cheque_transactions', function (Blueprint $table) {
            //
        });
    }
}
