<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CAddColumnToCommercialInvoiceDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commercial_invoice_details', function (Blueprint $table) {

            $table->integer('bundle1')->default(0);
            $table->integer('bundle2')->default(0);
            $table->decimal('dbalwt', 15, 3)->default(0.000);
            $table->integer('dbalpcs')->default(0);
            $table->integer('dbundle1')->default(0);
            $table->integer('dbundle2')->default(0);
            $table->integer('dtybal')->default(0);
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
        Schema::table('commercial_invoice_details', function (Blueprint $table) {
            //
        });
    }
}
