<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_order_details', function (Blueprint $table) {
            $table->id();
            $table->Integer('sale_invoice_id')->default(0);
            $table->Integer('material_id')->default(0);
            $table->tinyInteger('sku_id')->default(0);
            $table->string('repname', 100)->nullable();
            $table->string('brand', 50)->nullable();

            $table->decimal('qtykg', 15, 2)->default(0.00);
            // $table->decimal('qtypcs', 15, 3)->default(0.000);
            // $table->decimal('qtyfeet', 15, 3)->default(0.000);
            $table->decimal('price', 15, 2)->default(0.00);
            $table->decimal('saleamnt', 15, 2)->default(0.00);



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
        Schema::dropIfExists('purchase_order_details');
    }
}
