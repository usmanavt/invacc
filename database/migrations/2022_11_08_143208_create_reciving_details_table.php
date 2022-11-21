<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecivingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reciving_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reciving_id');
            $table->bigInteger('location_id');
            $table->string('location','50');
            $table->timestamp('machine_date')->nullable();
            $table->string('machineno', 30);
            $table->bigInteger('supplier_id');
            $table->bigInteger('commercial_invoice_id');
            $table->string('invoiceno', 30);
            $table->timestamp('reciving_date')->nullable();
            $table->smallInteger('status')->default(1);
            $table->decimal('qtyinpcs', 8, 3)->default(00.000);
            $table->decimal('qtyinkg', 8, 3)->default(00.000);
            $table->decimal('qtyinfeet', 8, 3)->default(00.000);
            $table->decimal('rateperpc', 15, 3)->nullable();
            $table->decimal('rateperkg', 15, 3)->nullable();
            $table->decimal('rateperft', 15, 3)->nullable();
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
        Schema::dropIfExists('reciving_details');
    }
}
