<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRecivingCompletedDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('reciving_completed_details', function (Blueprint $table) {
            $table->decimal('qtyinpcs', 15, 3)->default(00.000);
            $table->decimal('qtyinkg', 15, 3)->default(00.000);
            $table->decimal('qtyinfeet', 15, 3)->default(00.000);


        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
