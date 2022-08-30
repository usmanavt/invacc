<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblecontractmasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblecontractmaster', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id');
            $table->date('invdate');
            $table->string('invno',30);
            $table->decimal('convrate', 6, 2)->nullable();
            $table->decimal('insurance', 6, 2)->nullable();
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
        Schema::dropIfExists('tblecontractmaster');
    }
}
