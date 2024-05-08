<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BAddColumnToSaleInvoicesDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoices_detail', function (Blueprint $table) {
            $table->string('brand', 50)->nullable();
            $table->Integer('cominvid')->default(0);
            $table->decimal('qtykgcrt', 12, 2)->default(0.00);
            $table->decimal('qtypcscrt', 12, 2)->default(0.00);
            $table->decimal('qtyfeetcrt', 12, 2)->default(0.00);


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
