<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcommercialInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcommercial_invoices', function (Blueprint $table) {
            $table->id();
            $table->Integer('commercial_invoice_id');
            $table->timestamp('invoice_date');
            $table->string('invoiceno', 30);
            $table->timestamp('machine_date')->nullable();
            $table->string('machineno', 30);
            $table->Integer('totpcs');
            $table->decimal('totwt', 15, 3)->default(00.000);
            $table->decimal('totfeet', 15, 3)->default(00.000);
            $table->decimal('dutyval', 15, 3)->default(00.000);
            $table->tinyInteger('status')->default(1); //
            $table->tinyInteger('closed')->default(1); //
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
        Schema::dropIfExists('pcommercial_invoices');
    }
}
