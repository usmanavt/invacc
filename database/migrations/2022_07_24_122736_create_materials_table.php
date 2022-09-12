<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title',75);
            $table->string('nick',10);
            $table->bigInteger('category_id');
            $table->bigInteger('dimension_id');
            $table->bigInteger('sku_id');
            $table->bigInteger('brand_id');
            $table->bigInteger('source_id');
            $table->string('category');
            $table->string('dimension');
            $table->string('source');
            $table->string('sku');
            $table->string('brand');
            $table->smallInteger('status')->default(1); // 1-Active , 0-Deactive
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
        Schema::dropIfExists('materials');
    }
}
