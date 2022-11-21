<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplierIdToCommericalInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commercial_invoices', function (Blueprint $table) {
            $table->bigInteger('supplier_id')->nullable();
            $table->bigInteger('goods_received')->default(0);
            $table->smallInteger('status')->default(1); //
        });
        Schema::table('commercial_invoice_details', function (Blueprint $table) {
            $table->bigInteger('goods_received')->default(0);
            $table->smallInteger('status')->default(1); //
            $table->string('invoiceno', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commercial_invoices', function (Blueprint $table) {
            //
        });
        Schema::table('commercial_invoice_details', function (Blueprint $table) {
            //
        });
    }
}
