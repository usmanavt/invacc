<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastSaleRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('last_sale_rate', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('customer_id')->default(0);
            $table->decimal('salrate', 15, 3)->default(0.000);
            $table->Integer('material_id')->default(0);

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
        Schema::dropIfExists('last_sale_rate');
    }
}
