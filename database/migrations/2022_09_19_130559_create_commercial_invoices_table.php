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
            $table->timestamp('invoice_date');
            $table->string('invoiceno', 30);
            $table->string('challanno', 30);
            $table->decimal('conversionrate', 15, 3)->default(00.000);
            $table->decimal('insurance', 15, 3)->default(00.000);
            $table->decimal('bankcharges', 8, 3)->default(00.000);
            $table->decimal('collofcustom', 8, 3)->default(00.000);
            $table->decimal('exataxoffie', 8, 3)->default(00.000);
            $table->decimal('lngnshipdochrgs', 8, 3)->default(00.000);
            $table->decimal('localcartage', 8, 3)->default(00.000);
            $table->decimal('miscexplunchetc', 8, 3)->default(00.000);
            $table->decimal('customsepoy', 8, 3)->default(00.000);
            $table->decimal('weighbridge', 8, 3)->default(00.000);
            $table->decimal('miscexpenses', 8, 3)->default(00.000);
            $table->decimal('agencychrgs', 8, 3)->default(00.000);
            $table->decimal('otherchrgs', 8, 3)->default(00.000);
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
