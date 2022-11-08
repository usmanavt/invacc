<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusCodeToMultipleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->smallInteger('status')->default(1); //
        });
        Schema::table('contract_details', function (Blueprint $table) {
            $table->smallInteger('status')->default(1); //
        });

        Schema::table('hscodes', function (Blueprint $table) {
            $table->smallInteger('status')->default(1); //
        });

        Schema::table('users', function (Blueprint $table) {
            $table->smallInteger('status')->default(1); //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
