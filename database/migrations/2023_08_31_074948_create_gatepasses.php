<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatepasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gatepasses', function (Blueprint $table) {
            $table->id();
            $table->Integer('sale_invoice_id');
            $table->date('saldate');
            $table->Integer('dcno');
            $table->Integer('billno');
            $table->smallInteger('customer_id')->nullable();
            $table->Integer('gpseqid');
            $table->date('gpdate');
            $table->string('gpinvsno', 30);
            $table->decimal('gptotpcs', 15, 3)->default(00.000);
            $table->decimal('gptotwt', 15, 3)->default(00.000);
            $table->decimal('gptotfeet', 15, 3)->default(00.000);
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
        Schema::dropIfExists('gatepasses');
    }
}
