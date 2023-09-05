<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EAddColumnToCustomerOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_order_details', function (Blueprint $table) {
            $table->integer('obalpcs')->default(0);
            $table->decimal('obalfeet', 15, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_order_details', function (Blueprint $table) {
            //
        });
    }
}
