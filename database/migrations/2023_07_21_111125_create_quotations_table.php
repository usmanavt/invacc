<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('customer_id')->default(0);
            $table->timestamp('saldate')->nullable();
            $table->timestamp('valdate')->nullable();
            $table->integer('qutno')->default(0);
            $table->string('prno',50)->nullable();
            $table->bigInteger('gpno')->default(0);
            $table->decimal('discntper', 15, 3)->default(0.000);
            $table->decimal('discntamt', 15, 3)->default(0.000);
            $table->decimal('cartage', 15, 3)->default(0.000);
            $table->decimal('rcvblamount', 15, 3)->default(0.000);
            $table->smallInteger('saletaxper')->default(0);
            $table->smallInteger('saletaxamt')->default(0);
            $table->smallInteger('totrcvbamount')->default(0);
            $table->string('Remarks', 150)->nullable();
            $table->string('repcustname', 100)->nullable();
            $table->string('repcustadrs', 150)->nullable();
            $table->string('cashcustomer', 100)->nullable();
            $table->string('cashcustadrs', 150)->nullable();


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
        Schema::dropIfExists('quotation');
    }
}
