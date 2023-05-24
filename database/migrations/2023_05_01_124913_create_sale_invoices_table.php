<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('customer_id')->default(0);
            $table->timestamp('saldate')->nullable();
            $table->bigInteger('dcno')->default(0);
            $table->bigInteger('billno')->default(0);
            $table->bigInteger('gpno')->default(0);
            $table->decimal('discntper', 15, 3)->default(0.000);
            $table->decimal('discntamt', 15, 3)->default(0.000);
            $table->decimal('cartage', 15, 3)->default(0.000);
            $table->decimal('rcvblamount', 15, 3)->default(0.000);
            $table->smallInteger('saletaxper')->default(0);
            $table->smallInteger('saletaxamt')->default(0);
            $table->smallInteger('totrcvbamount')->default(0);
            $table->string('Remarks', 150)->nullable();
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
        //
    }
}
