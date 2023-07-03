<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcommercialInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcommercial_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('commercial_invoice_id');
            $table->bigInteger('material_id');
            $table->decimal('pcs', 12, 3)->default(00.000);
            $table->decimal('gdswt', 12, 3)->default(00.000);
            $table->decimal('gdsprice', 12, 3)->default(00.000);
            $table->decimal('dutyval', 12, 3)->default(00.000);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('closed')->default(1);
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
        Schema::dropIfExists('pcommercial_invoice_details');
    }
}
