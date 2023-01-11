<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->timestamp('document_date')->nullable();
            $table->string('transaction_type', 6)->nullable();  // BPV , BRP
            $table->bigInteger('head_id')->default(0);
            $table->bigInteger('subhead_id')->default(0);
            $table->Integer('jvno')->default(0);
            $table->decimal('amount',15,3)->default(0.00);
            $table->string('description', 100)->nullable();
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
        Schema::dropIfExists('vouchers');
    }
};
