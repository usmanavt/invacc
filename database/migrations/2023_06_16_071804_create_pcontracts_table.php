<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcontractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcontracts', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('supplier_id');
            $table->integer('contract_id')->nullable();
            $table->smallInteger('user_id');
            $table->timestamp('invoice_date');
            $table->string('number',20);
            $table->decimal('conversion_rate', 10, 3)->nullable();
            $table->decimal('insurance', 10, 3)->nullable();
            $table->decimal('dutyval', 15, 2)->nullable();
            $table->integer('totalpcs')->nullable();
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
        Schema::dropIfExists('pcontracts');
    }
}
