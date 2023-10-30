<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPurchaseReturnDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_return_details', function (Blueprint $table) {
            $table->decimal('prtbalwt', 12, 2)->default(00.00);
            $table->decimal('prtbalpcs', 12, 2)->default(00.00);
            $table->decimal('prtbalfeet', 12, 2)->default(00.00);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_return_details', function (Blueprint $table) {
            //
        });
    }
}
