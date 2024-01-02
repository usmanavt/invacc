<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToLastSaleRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('last_sale_rate', function (Blueprint $table) {
            $table->tinyInteger('sunitid')->default(0);
            $table->string('sunitname', 10)->nullable();
            $table->Integer('tranid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('last_sale_rate', function (Blueprint $table) {
            //
        });
    }
}
