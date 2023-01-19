<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToClearanceCompletedDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clearance_completed_details', function (Blueprint $table) {
            $table->decimal('conrate', 15, 3)->default(00.000);
            $table->decimal('insrnce', 15, 3)->default(00.000);



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('_clearance_completed_details', function (Blueprint $table) {
            //
        });
    }
}
