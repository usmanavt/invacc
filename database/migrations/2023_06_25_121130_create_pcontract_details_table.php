<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcontractDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcontract_details', function (Blueprint $table) {
            $table->id();
            $table->Integer('contract_id');
            $table->Integer('commercial_invoice_id')->nullable();
            $table->Integer('material_id');
            $table->Integer('user_id');
            $table->decimal('bundle1',6,2);
            $table->decimal('pcspbundle1',6,2);
            $table->decimal('bundle2',6,2)->nullable();
            $table->decimal('pcspbundle2',6,2)->nullable();
            $table->decimal('gdswt', 15,3);
            $table->decimal('gdsprice',15,3);
            $table->smallInteger('status')->default(1); // 1=pending, 2 = completed
            $table->smallInteger('closed')->default(1); // 1=open, 2=closed
            $table->decimal('purval', 15,3);
            $table->decimal('totpcs', 15,3);
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
        Schema::dropIfExists('pcontract_details');
    }
}
