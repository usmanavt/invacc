<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('customer_id');
            $table->string('pono',50)->nullable();
            $table->string('poseqno',50)->nullable();
            $table->date('podate')->nullable();
            $table->date('deliverydt')->nullable();
            $table->decimal('discntper', 6, 2)->default(0.00);
            $table->decimal('discntamt', 15, 3)->default(0.00);
            $table->decimal('cartage', 15, 3)->default(0.00);
            $table->decimal('rcvblamount', 15, 3)->default(0.00);
            $table->decimal('saletaxper', 6, 2)->default(0.00);
            $table->integer('saletaxamt')->default(0);
            $table->integer('totrcvbamount')->default(0);
            $table->string('remarks', 150)->nullable();
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
        Schema::dropIfExists('customer_orders');
    }
}
