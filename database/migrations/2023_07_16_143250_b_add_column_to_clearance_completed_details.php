<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BAddColumnToClearanceCompletedDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clearance_completed_details', function (Blueprint $table) {
            $table->decimal('dtyinsuranceperitemrs', 15, 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clearance_completed_details', function (Blueprint $table) {
            //
        });
    }
}
