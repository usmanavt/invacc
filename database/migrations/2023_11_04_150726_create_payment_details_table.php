<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->Integer('paymentid');
            $table->Integer('invoice_id');
            $table->string('invoice_no', 30);
            $table->date('invoice_date');
            $table->decimal('amountrs', 15, 3)->default(00.000);
            $table->decimal('amountdlrs', 15, 3)->default(00.000);
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
        Schema::dropIfExists('payment_details');
    }
}
