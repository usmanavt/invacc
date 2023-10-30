<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPurchaseReturns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_returns', function (Blueprint $table) {

            $table->date('prinvdate')->nullable();;
            $table->string('prinvno','50')->nullable();
            $table->decimal('prbalpcs', 15, 2)->default(00.00);
            $table->decimal('prbalwt', 15, 2)->default(00.00);
            $table->decimal('prbalfeet', 15, 2)->default(00.00);




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_returns', function (Blueprint $table) {
            //
        });
    }
}
