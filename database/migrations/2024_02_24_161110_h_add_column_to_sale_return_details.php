<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HAddColumnToSaleReturnDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_return_details', function (Blueprint $table) {
            $table->decimal('unitconversr', 12, 3)->default(00.000);
            $table->decimal('srfeedqty', 12, 3)->default(00.000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_return_details', function (Blueprint $table) {
            //
        });
    }
}
