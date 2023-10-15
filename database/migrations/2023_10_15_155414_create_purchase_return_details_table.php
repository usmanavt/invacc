<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_return_details', function (Blueprint $table) {
            $table->id();
            $table->Integer('prid');
            $table->Integer('material_id');
            $table->tinyInteger('prunitid')->default(0);
            $table->decimal('prwt', 12, 2)->default(00.00);
            $table->decimal('prpcs', 12, 2)->default(00.00);
            $table->decimal('prfeet', 12, 2)->default(00.00);
            $table->decimal('prprice', 12, 2)->default(00.00);
            $table->decimal('pramount', 12, 2)->default(00.00);

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
        Schema::dropIfExists('purchase_return_details');
    }
}
