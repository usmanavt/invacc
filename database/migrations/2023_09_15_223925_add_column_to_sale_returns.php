<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSaleReturns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_returns', function (Blueprint $table) {
            $table->decimal('tsrwt', 15, 2)->default(00.00);
            $table->decimal('tsrpcs', 15, 2)->default(00.00);
            $table->decimal('tsrfeet', 15, 2)->default(00.00);
            $table->decimal('psrwt', 15, 2)->default(00.00);
            $table->decimal('psrpcs', 15, 2)->default(00.00);
            $table->decimal('psrfeet', 15, 2)->default(00.00);



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_returns', function (Blueprint $table) {
            //
        });
    }
}
