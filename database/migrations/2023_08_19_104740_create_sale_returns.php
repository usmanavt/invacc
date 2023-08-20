<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_returns', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('customer_id')->default(0);
            $table->smallInteger('invoice_id')->default(0);
            // $table->string('pono',50)->nullable();
            $table->date('dcdate')->nullable();
            $table->timestamp('rdate')->nullable();
            $table->smallInteger('dcno')->default(0);
            $table->smallInteger('billno')->default(0);
            $table->smallInteger('gpno')->default(0);
            $table->smallInteger('returnno')->default(0);

            // $table->decimal('discntper', 15, 3)->default(0.000);
            // $table->decimal('discntamt', 15, 3)->default(0.000);
            // $table->decimal('cartage', 15, 3)->default(0.000);
            $table->decimal('rcvblamount', 15, 3)->default(0.000);
            $table->smallInteger('saletaxper')->default(0);
            $table->smallInteger('saletaxamt')->default(0);
            $table->smallInteger('totrcvbamount')->default(0);
            $table->string('Remarks', 150)->nullable();
            $table->tinyInteger('status')->default(1); // 1=pending, 2 = completed
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
        Schema::dropIfExists('sale_return');
    }
}
