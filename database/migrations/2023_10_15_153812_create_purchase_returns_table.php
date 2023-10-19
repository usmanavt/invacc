<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->Integer('commercial_invoice_id')->nullable();
            $table->date('prdate');
            $table->smallInteger('prno')->nullable();
            $table->decimal('prtwt', 12, 2)->default(00.00);
            $table->decimal('prtpcs', 12, 2)->default(00.00);
            $table->decimal('prtfeet', 12, 2)->default(00.00);
            $table->decimal('prtamount', 12, 2)->default(00.00);
            $table->smallInteger('supplier_id')->default(0);
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
        Schema::dropIfExists('purchase_returns');
    }
}
