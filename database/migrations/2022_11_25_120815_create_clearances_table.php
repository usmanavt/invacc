<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClearancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clearances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('commercial_invoice_id');
            $table->string('gdno', 30)->nullable();
            $table->timestamp('gd_date')->nullable();
            $table->timestamp('invoice_date')->nullable();
            $table->string('invoiceno', 30);
            $table->timestamp('machine_date')->nullable();
            $table->string('machineno', 30);
            $table->bigInteger('supplier_id');
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
            $table->smallInteger('cleared')->default(1); // 1 = pending, 2 = completed
            $table->smallInteger('clearmade')->default(1); // 1 = pending, 2 = completed
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
        Schema::dropIfExists('clearances');
    }
}
