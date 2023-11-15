<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPaymentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_details', function (Blueprint $table) {
            $table->smallInteger('supplier_id')->default(0);
            $table->decimal('invoice_amount', 12, 3)->default(00.000);
            $table->string('curncy', 6);
            $table->decimal('payedusd', 12, 3)->default(00.000);
            $table->decimal('convrate', 12, 3)->default(00.000);
            $table->decimal('payedrup', 12, 3)->default(00.000);
            $table->decimal('invoice_bal', 12, 3)->default(00.000);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_details', function (Blueprint $table) {
            //
        });
    }
}
