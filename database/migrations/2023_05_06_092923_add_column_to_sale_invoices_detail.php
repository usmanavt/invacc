<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSaleInvoicesDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoices_detail', function (Blueprint $table) {
            $table->smallInteger('locid')->default(0);
            $table->smallInteger('salunitid')->default(0);
            $table->string('location`', 25)->nullable();
            $table->string('sku`', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_invoices_detail', function (Blueprint $table) {
            //
        });
    }
}
