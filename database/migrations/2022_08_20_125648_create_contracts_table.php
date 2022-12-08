<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id');
            $table->bigInteger('user_id');
            $table->string('invoice_date');
            $table->string('number',20);
            $table->decimal('conversion_rate', 15, 3)->nullable();
            $table->decimal('insurance', 15, 3)->nullable();
            $table->smallInteger('status')->default(1); // 1=pending, 2 = completed
            $table->smallInteger('closed')->default(1); // 1=open, 2=closed
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
        Schema::dropIfExists('contracts');
    }
}
