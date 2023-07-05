<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Abc1111AddColumnToCommercialInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commercial_invoices', function (Blueprint $table) {
            $table->Integer('tpcs')->default(0);
            $table->decimal('twt', 12, 3)->default(00.000);
            $table->decimal('tval', 12, 3)->default(00.000);
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
    }
}
