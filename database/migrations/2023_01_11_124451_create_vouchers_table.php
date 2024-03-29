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
            $table->string('transaction',16);
            $table->timestamp('document_date')->nullable();
            $table->string('transaction_type', 6)->nullable();  // BPV , BRP
            $table->smallInteger('head_id');
            $table->string('head_title',50);
            $table->smallInteger('subhead_id');
            $table->string('subhead_title',50);
            $table->string('jvno',100);
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
