<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCommercialInvoiceDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commercial_invoice_details', function (Blueprint $table) {

            Schema::table('commercial_invoice_details', function (Blueprint $table) {
                $table->decimal('dtyrate', 15, 3)->default(00.000);
                $table->decimal('invsrate', 15, 3)->default(00.000);



            });






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
