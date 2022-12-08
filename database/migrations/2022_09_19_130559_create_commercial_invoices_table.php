<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommercialInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contract_id');
            $table->timestamp('invoice_date');
            $table->string('invoiceno', 30);
            $table->string('challanno', 30);
            $table->timestamp('machine_date')->nullable();
            $table->string('machineno', 30);
            $table->bigInteger('supplier_id')->nullable();
            $table->bigInteger('goods_received')->default(0);
            $table->smallInteger('status')->default(1); //
            $table->decimal('conversionrate', 15, 3)->default(00.000);
            $table->decimal('insurance', 15, 3)->default(00.000);
            $table->decimal('bankcharges', 15, 3)->default(00.000);
            $table->decimal('collofcustom', 15, 3)->default(00.000);
            $table->decimal('exataxoffie', 15, 3)->default(00.000);
            $table->decimal('lngnshipdochrgs', 15, 3)->default(00.000);
            $table->decimal('localcartage', 15, 3)->default(00.000);
            $table->decimal('miscexplunchetc', 15, 3)->default(00.000);
            $table->decimal('customsepoy', 15, 3)->default(00.000);
            $table->decimal('weighbridge', 15, 3)->default(00.000);
            $table->decimal('miscexpenses', 15, 3)->default(00.000);
            $table->decimal('agencychrgs', 15, 3)->default(00.000);
            $table->decimal('otherchrgs', 15, 3)->default(00.000);
            $table->decimal('total', 15, 3)->default(00.000);
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
        Schema::dropIfExists('commercial_invoices');
    }
}
