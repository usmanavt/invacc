<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGodownsrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('godownsrs', function (Blueprint $table) {
            $table->id();
            $table->Integer('cominvid');
            $table->Integer('contract_id');
            $table->date('contract_date');
            $table->smallInteger('customer_id')->nullable();
            $table->date('purinvdt');
            $table->string('purinvsno', 30);
            $table->Integer('gpno');
            $table->date('gpdate');
            $table->Integer('purtotpcs');
            $table->decimal('purtotwt', 15, 2)->default(00.00);
            $table->decimal('purtotfeet', 15, 2)->default(00.00);
            $table->tinyInteger('status')->default(1); //
            $table->tinyInteger('closed')->default(1); //
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('godownsr');
    }
}
