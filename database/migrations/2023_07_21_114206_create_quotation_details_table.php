<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sale_invoice_id')->default(0);
            $table->bigInteger('material_id')->default(0);
            $table->tinyInteger('sku_id')->default(0);
            $table->string('repname', 100)->nullable();
            $table->string('brand', 50)->nullable();

            $table->decimal('qtykg', 15, 3)->default(0.000);
            $table->decimal('qtypcs', 15, 3)->default(0.000);
            $table->decimal('qtyfeet', 15, 3)->default(0.000);
            $table->decimal('price', 15, 3)->default(0.000);
            $table->decimal('saleamnt', 15, 3)->default(0.000);
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
        Schema::dropIfExists('quotation_details');
    }
}
