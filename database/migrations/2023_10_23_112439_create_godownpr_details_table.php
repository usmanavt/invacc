<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGodownprDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('godownpr_details', function (Blueprint $table) {
            $table->id();

            // $table->Integer('gpid');
            $table->Integer('gprid');
            $table->Integer('material_id')->default(0);
            $table->Integer('tcontract_id')->default(0);
            $table->tinyInteger('sku_id')->default(0);
            // $table->string('brand', 50);
            // $table->string('repname', 50);

            $table->decimal('prgpwte13', 15, 3)->default(00.000);
            $table->decimal('prgppcse13', 15, 3)->default(00.000);
            $table->decimal('prgpfeete13', 15, 3)->default(00.000);

            $table->decimal('prgpwtgn2', 15, 3)->default(00.000);
            $table->decimal('prgppcsgn2', 15, 3)->default(00.000);
            $table->decimal('prgpfeetgn2', 15, 3)->default(00.000);

            $table->decimal('prgpwtams', 15, 3)->default(00.000);
            $table->decimal('prgppcsams', 15, 3)->default(00.000);
            $table->decimal('prgpfeetams', 15, 3)->default(00.000);

            $table->decimal('prgpwte24', 15, 3)->default(00.000);
            $table->decimal('prgppcse24', 15, 3)->default(00.000);
            $table->decimal('prgpfeete24', 15, 3)->default(00.000);


            $table->decimal('prgpwtbs', 15, 3)->default(00.000);
            $table->decimal('prgppcsbs', 15, 3)->default(00.000);
            $table->decimal('prgpfeetbs', 15, 3)->default(00.000);

            $table->decimal('prgpwtoth', 15, 3)->default(00.000);
            $table->decimal('prgppcsoth', 15, 3)->default(00.000);
            $table->decimal('prgpfeetoth', 15, 3)->default(00.000);

            $table->decimal('prgpwttot', 15, 3)->default(00.000);
            $table->decimal('prgppcstot', 15, 3)->default(00.000);
            $table->decimal('prgpfeettot', 15, 3)->default(00.000);

            // $table->tinyInteger('length')->default(0);

            $table->decimal('prgpkgrate', 15, 3)->default(00.000);
            $table->decimal('prgppcsrate', 15, 3)->default(00.000);
            $table->decimal('prgpfeetrate', 15, 3)->default(00.000);

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
        Schema::dropIfExists('godownpr_details');
    }
}
