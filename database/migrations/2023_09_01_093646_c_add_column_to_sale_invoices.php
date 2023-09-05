<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CAddColumnToSaleInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoices', function (Blueprint $table) {
            $table->decimal('sltwt', 15, 3)->default(00.000);
            $table->Integer('sltpcs')->default(0);
            $table->decimal('slfeet', 15, 3)->default(00.000);
            $table->decimal('balsltwt', 15, 3)->default(00.000);
            $table->Integer('balsltpcs')->default(0);
            $table->decimal('balslfeet', 15, 3)->default(00.000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_invoices', function (Blueprint $table) {
            //
        });
    }
}
