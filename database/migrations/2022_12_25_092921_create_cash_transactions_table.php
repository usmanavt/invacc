<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bank_id')->default(0);
            $table->bigInteger('head_id')->default(0);
            $table->bigInteger('subhead_id')->default(0);
            $table->bigInteger('supplier_id')->default(0);
            $table->bigInteger('customer_id')->default(0);
            $table->string('transaction_type', 5)->default('BPV');  // BPV , BRP
            $table->decimal('conversion_rate', 15, 3)->default(1);
            $table->decimal('amount_fc', 15, 3)->default(0.000);
            $table->decimal('amount_pkr', 15, 3)->default(0.000);
            $table->timestamp('cheque_date')->nullable();
            $table->string('cheque_no', 32)->nullable();
            $table->string('description', 255)->nullable();
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
        Schema::dropIfExists('cash_transactions');
    }
}
