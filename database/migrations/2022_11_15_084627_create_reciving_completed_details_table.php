<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecivingCompletedDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reciving_completed_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reciving_id');
            $table->string('location','50');
            $table->timestamp('machine_date')->nullable();
            $table->string('machineno', 30);
            $table->bigInteger('supplier_id');
            $table->bigInteger('commercial_invoice_id');
            $table->string('invoiceno', 30);
            $table->bigInteger('material_id');
            $table->string('material_title',75);
            $table->timestamp('reciving_date')->nullable();
            $table->smallInteger('status')->default(2);
            $table->decimal('received', 8, 3)->default(00.000);
            $table->decimal('rejected', 8, 3)->default(00.000);
            $table->decimal('thisgr', 8, 3)->default(00.000);
            $table->decimal('rateperft', 8, 3)->default(00.000);
            $table->decimal('rateperkg', 8, 3)->default(00.000);
            $table->decimal('rateperpc', 8, 3)->default(00.000);
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
        Schema::dropIfExists('reciving_completed_details');
    }
}
