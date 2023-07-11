<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AAddColumnToClearanceCompletedDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clearance_completed_details', function (Blueprint $table) {
            $table->smallInteger('bundle1')->nullable();
            $table->smallInteger('pcspbundle1')->nullable();
            $table->smallInteger('bundle2')->nullable();
            $table->smallInteger('pcspbundle2')->nullable();
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
