<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAddColumnToCommercialInvoiceDetails extends Migration
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
                $table->smallInteger('locid')->default(0);
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
        Schema::table('add_column_to_commercial_invoice_details', function (Blueprint $table) {
            //
        });
    }
}
