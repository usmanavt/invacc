<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AAddColumnToContractDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_details', function (Blueprint $table) {
            $table->decimal('purval', 15, 2)->nullable();
            $table->integer('totpcs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_details', function (Blueprint $table) {
            //
        });
    }
}
