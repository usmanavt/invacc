<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeItemBal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_item_bal', function (Blueprint $table) {
            $table->id();
            $table->Integer('transaction_id')->default(0);
            $table->date('tdate')->nullable();
            $table->string('ttypedesc',20)->nullable();
            $table->tinyInteger('ttypeid')->default(0);
            $table->Integer('material_id')->default(0);
            $table->decimal('tqtykg', 15, 3)->default(0.000);
            $table->decimal('tqtypcs', 15, 3)->default(0.000);
            $table->decimal('tqtyfeet', 15, 3)->default(0.000);
            $table->decimal('tcostkg', 15, 3)->default(0.000);
            $table->decimal('tcostpcs', 15, 3)->default(0.000);
            $table->decimal('tcostfeet', 15, 3)->default(0.000);
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
        Schema::dropIfExists('office_item_bal');
    }
}
