<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatepasseDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gatepasse_details', function (Blueprint $table) {
            $table->id();
            $table->Integer('gpid');
            $table->Integer('sale_invoice_id');
            $table->Integer('material_id')->default(0);
            $table->tinyInteger('sku_id')->default(0);
            $table->string('brand', 50);
            $table->string('repname', 50);

            $table->decimal('gpwte13', 15, 3)->default(00.000);
            $table->decimal('gppcse13', 15, 3)->default(00.000);
            $table->decimal('gpfeete13', 15, 3)->default(00.000);

            $table->decimal('gpwtgn2', 15, 3)->default(00.000);
            $table->decimal('gppcsgn2', 15, 3)->default(00.000);
            $table->decimal('gpfeetgn2', 15, 3)->default(00.000);

            $table->decimal('gpwtams', 15, 3)->default(00.000);
            $table->decimal('gppcsams', 15, 3)->default(00.000);
            $table->decimal('gpfeetams', 15, 3)->default(00.000);

            $table->decimal('gpwte24', 15, 3)->default(00.000);
            $table->decimal('gppcse24', 15, 3)->default(00.000);
            $table->decimal('gpfeete24', 15, 3)->default(00.000);


            $table->decimal('gpwtbs', 15, 3)->default(00.000);
            $table->decimal('gppcsbs', 15, 3)->default(00.000);
            $table->decimal('gpfeetbs', 15, 3)->default(00.000);

            $table->decimal('gpwtoth', 15, 3)->default(00.000);
            $table->decimal('gppcsoth', 15, 3)->default(00.000);
            $table->decimal('gpfeetoth', 15, 3)->default(00.000);

            $table->decimal('gpwttot', 15, 3)->default(00.000);
            $table->decimal('gppcstot', 15, 3)->default(00.000);
            $table->decimal('gpfeettot', 15, 3)->default(00.000);

            // $table->tinyInteger('length')->default(0);

            $table->decimal('gpkgrate', 15, 3)->default(00.000);
            $table->decimal('gppcsrate', 15, 3)->default(00.000);
            $table->decimal('gpfeetrate', 15, 3)->default(00.000);

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
        Schema::dropIfExists('gatepasse_details');
    }
}
