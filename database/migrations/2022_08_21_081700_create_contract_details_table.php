<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contract_id');
            $table->bigInteger('material_id');
            $table->bigInteger('supplier_id');
            $table->bigInteger('user_id');
            $table->bigInteger('category_id');
            $table->bigInteger('sku_id');
            $table->bigInteger('dimension_id');
            $table->bigInteger('source_id');
            $table->bigInteger('brand_id');
            $table->string('category');
            $table->string('sku');  
            $table->string('dimension');
            $table->string('source');
            $table->string('brand');
            $table->decimal('bundle1',6,2);
            $table->decimal('pcspbundle1',6,2);
            $table->decimal('bundle2',6,2)->nullable();
            $table->decimal('pcspbundle2',6,2)->nullable();
            $table->decimal('gdswt', 15,2);
            $table->decimal('gdsprice',15,2);
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
        Schema::dropIfExists('contract_details');
    }
}
