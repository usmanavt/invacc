<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recivings', function (Blueprint $table) {
            $table->id();
            $table->timestamp('machine_date')->nullable();
            $table->string('machineno', 30);
            $table->bigInteger('supplier_id');
            $table->bigInteger('commercial_invoice_id');
            $table->string('invoiceno', 30);
            $table->timestamp('reciving_date')->nullable();
            $table->smallInteger('status')->default(1); //
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
        Schema::dropIfExists('recivings');
    }
}
