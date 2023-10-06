<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EAddColumnToCommercialInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commercial_invoices', function (Blueprint $table) {
             $table->tinyInteger('packingid')->default(0);
             $table->smallInteger('packingwt')->nullable();
             $table->smallInteger('packingwtbal')->nullable();
             $table->decimal('tdutval', 15, 2)->default(00.00);
             $table->decimal('tdutvalbal', 15, 2)->default(00.00);
             $table->Integer('pcsbal')->nullable();


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
