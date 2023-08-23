<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemBal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_bal', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('locid')->default(0);
            $table->Integer('material_id')->default(0);
            $table->decimal('obqtykg', 15, 3)->default(0.000);
            $table->decimal('obqtypcs', 15, 3)->default(0.000);
            $table->decimal('obqtyfeet', 15, 3)->default(0.000);
            $table->decimal('cbqtykg', 15, 3)->default(0.000);
            $table->decimal('cbqtypcs', 15, 3)->default(0.000);
            $table->decimal('cbqtyfeet', 15, 3)->default(0.000);


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
        Schema::dropIfExists('item_bal');
    }
}
