<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CAddColumnToCommercialInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commercial_invoices', function (Blueprint $table) {
            $table->integer('tduty')->default(0);
            $table->integer('payed')->default(0);
            $table->integer('dutybal')->default(0);
            $table->decimal('tswt', 15, 3)->default(0.000);
            $table->integer('purid')->default(0);
            $table->decimal('wtbal', 15, 3)->default(0.000);

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
