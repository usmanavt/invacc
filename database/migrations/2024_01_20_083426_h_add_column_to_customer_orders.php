<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HAddColumnToCustomerOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->decimal('tplnqty', 12, 2)->default(00.00);
            $table->decimal('tslwt', 12, 2)->default(00.00);
            $table->Integer('tslpcs')->default(0);
            $table->decimal('tslfeet', 12, 2)->default(00.00);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            //
        });
    }
}
