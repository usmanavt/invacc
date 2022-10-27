<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommercialInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->timestamp('machine_date')->nullable();
            $table->string('machineno', 30);
            $table->bigInteger('commercial_invoice_id');
            $table->bigInteger('contract_id');
            $table->bigInteger('material_id');
            $table->bigInteger('supplier_id');
            $table->bigInteger('user_id');
            $table->bigInteger('category_id');
            $table->bigInteger('sku_id');
            $table->bigInteger('dimension_id');
            $table->bigInteger('source_id');
            $table->bigInteger('brand_id');

            $table->decimal('pcs', 8, 3)->default(00.000);
            $table->decimal('gdswt', 8, 3)->default(00.000);
            $table->decimal('inkg', 8, 3)->default(00.000);
            $table->decimal('gdsprice', 8, 3)->default(00.000);
            $table->decimal('amtindollar', 15, 3)->default(00.000);
            $table->decimal('amtinpkr', 15, 3)->default(00.000);

            $table->string('hscode', 25);
            $table->decimal('cd', 8, 3)->nullable();
            $table->decimal('st', 8, 3)->nullable();
            $table->decimal('rd', 8, 3)->nullable();
            $table->decimal('acd', 8, 3)->nullable();
            $table->decimal('ast', 8, 3)->nullable();
            $table->decimal('it', 8, 3)->nullable();
            $table->decimal('wse', 8, 3)->nullable();

            $table->decimal('length', 8, 3)->nullable();
            $table->decimal('itmratio', 8, 3)->nullable();
            $table->decimal('insuranceperitem', 15, 3)->nullable();
            $table->decimal('amountwithoutinsurance', 15, 3)->nullable();
            $table->decimal('onepercentdutypkr', 15, 3)->nullable();
            $table->decimal('pricevaluecostsheet', 15, 3)->nullable();

            $table->decimal('cda', 15, 3)->default(00.000);
            $table->decimal('sta', 15, 3)->default(00.000);
            $table->decimal('rda', 15, 3)->default(00.000);
            $table->decimal('acda', 15, 3)->default(00.000);
            $table->decimal('asta', 15, 3)->default(00.000);
            $table->decimal('ita', 15, 3)->default(00.000);
            $table->decimal('wsca', 15, 3)->default(00.000);
            $table->decimal('total', 15, 3)->default(00.000);
            $table->decimal('perpc', 15, 3)->nullable();
            $table->decimal('perkg', 15, 3)->nullable();
            $table->decimal('perft', 15, 3)->nullable();

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
        Schema::dropIfExists('commercial_invoice_details');
    }
}
