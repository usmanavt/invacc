<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CAddColumnToSaleInvoicesDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoices_detail', function (Blueprint $table) {
            $table->decimal('feedqty', 15, 3)->default(0.000);
            $table->decimal('sqtykg', 15, 3)->default(0.000);
            $table->integer('sqtypcs')->default(0);
            $table->decimal('sqtyfeet', 15, 3)->default(0.000);
            $table->decimal('wtper', 15, 3)->default(0.000);
            $table->decimal('pcper', 15, 3)->default(0.000);
            $table->decimal('feetper', 15, 3)->default(0.000);


            $table->decimal('salepcs', 15, 3)->default(0.000);
            $table->decimal('salewt', 15, 3)->default(0.000);
            $table->decimal('salefeet', 15, 3)->default(0.000);





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
