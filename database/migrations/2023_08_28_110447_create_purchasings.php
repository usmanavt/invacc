<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasings', function (Blueprint $table) {
            $table->id();
            $table->Integer('contract_id');
            $table->date('contract_date');
            $table->smallInteger('supplier_id')->nullable();
            $table->Integer('purseqid');
            $table->date('purdate');
            $table->string('purinvsno', 30);
            $table->Integer('purtotpcs');
            $table->decimal('purtotwt', 15, 3)->default(00.000);
            $table->decimal('purtotfeet', 15, 3)->default(00.000);
            $table->Integer('balpurtotpcs');
            $table->decimal('balpurtotwt', 15, 3)->default(00.000);
            $table->decimal('balpurtotfeet', 15, 3)->default(00.000);
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
        Schema::dropIfExists('purchasings');
    }
}
