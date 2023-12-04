<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGodownMovementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('godown_movement_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('godown_movement_id')->default(0);
            $table->bigInteger('material_id')->default(0);
            $table->tinyInteger('sku_id')->default(0);
            $table->string('repname', 150)->nullable();

            $table->decimal('qtykg', 15, 3)->default(0.000);
            $table->decimal('qtypcs', 15, 3)->default(0.000);
            $table->decimal('qtyfeet', 15, 3)->default(0.000);
            $table->decimal('price', 15, 3)->default(0.000);
            $table->decimal('saleamnt', 15, 3)->default(0.000);

            $table->smallInteger('locid')->default(0);
            $table->smallInteger('salunitid')->default(0);
            $table->string('location`', 25)->nullable();
            $table->string('sku`', 10)->nullable();

            $table->string('brand', 50)->nullable();
            $table->Integer('cominvid')->default(0);
            $table->decimal('qtykgcrt', 12, 2)->default(0.00);
            $table->decimal('qtypcscrt', 12, 2)->default(0.00);
            $table->decimal('qtyfeetcrt', 12, 2)->default(0.00);

            $table->decimal('feedqty', 15, 3)->default(0.000);
            $table->decimal('sqtykg', 15, 3)->default(0.000);
            $table->integer('sqtypcs')->default(0);
            $table->decimal('sqtyfeet', 15, 3)->default(0.000);
            $table->decimal('wtper', 15, 3)->default(0.000);
            $table->decimal('pcper', 15, 3)->default(0.000);
            $table->decimal('feetper', 15, 3)->default(0.000);


            $table->decimal('salepcs', 15, 3)->default(0.000);
            $table->decimal('salewt', 15, 3)->default(0.000);
            $table->decimal('salefeet', 15, 3)->default(0.000);

            $table->decimal('unitconver', 10, 3)->default(00.000);
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
        Schema::dropIfExists('godown_movement_details');
    }
}
