<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiveDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_details', function (Blueprint $table) {
            $table->id();
            $table->Integer('receivedid');
            $table->Integer('invoice_id');
            $table->string('pono', 25)->nullable();
            $table->date('saldate');
            $table->Integer('billno');
            $table->Integer('dcno');
            $table->decimal('dcamount', 12, 1)->default(00.0);
            $table->decimal('staxper', 12, 2)->default(00.00);
            $table->decimal('staxamount', 12, 1)->default(00.0);
            $table->decimal('totrcvble', 12, 1)->default(00.0);
            $table->decimal('totrcvd', 12, 1)->default(00.0);
            $table->decimal('invoice_bal', 12, 1)->default(00.0);
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
        Schema::dropIfExists('receive_details');
    }
}
