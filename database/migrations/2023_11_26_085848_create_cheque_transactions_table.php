<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChequeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheque_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bank_id');
            $table->bigInteger('head_id');
            $table->bigInteger('subhead_id')->default(0);
            $table->bigInteger('supplier_id')->default(0);
            $table->bigInteger('customer_id')->default(0);
            $table->date('documentdate');
            $table->Integer('received')->default(0);
            $table->Integer('payment')->default(0);
            $table->date('cheque_date')->nullable();
            $table->string('cheque_no', 32)->nullable();
            $table->string('description', 255)->nullable();
            $table->tinyInteger('clrstatus')->default(0);
            $table->date('clrdate')->nullable();
            $table->Integer('clrid')->default(0);
            $table->string('ref', 20)->nullable();
            $table->smallInteger('status')->default(1); //
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
        Schema::dropIfExists('_cheque_transaction');
    }
}
