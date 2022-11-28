<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalLcCostWExpToCommericalInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commercial_invoice_details', function (Blueprint $table) {
            $table->decimal('totallccostwexp', 15, 3)->default(123.45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commercial_invoice_details', function (Blueprint $table) {
            //
        });
    }
}
