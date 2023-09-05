<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasingDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('purchasing_details', function (Blueprint $table) {
            $table->id();
            $table->Integer('purid');
            $table->Integer('contract_id')->default(0);
            $table->Integer('material_id')->default(0);
            $table->tinyInteger('sku_id')->default(0);
            $table->string('brand', 50);
            $table->string('repname', 50);

            $table->decimal('purwte13', 15, 3)->default(00.000);
            $table->Integer('purpcse13')->default(0);
            $table->decimal('purfeete13', 15, 3)->default(00.000);

            $table->decimal('purwtgn2', 15, 3)->default(00.000);
            $table->Integer('purpcsgn2')->default(0);
            $table->decimal('purfeetgn2', 15, 3)->default(00.000);

            $table->decimal('purwtams', 15, 3)->default(00.000);
            $table->Integer('purpcsams')->default(0);
            $table->decimal('purfeetams', 15, 3)->default(00.000);

            $table->decimal('purwte24', 15, 3)->default(00.000);
            $table->Integer('purpcse24')->default(0);
            $table->decimal('purfeete24', 15, 3)->default(00.000);


            $table->decimal('purwtbs', 15, 3)->default(00.000);
            $table->Integer('purpcsbs')->default(0);
            $table->decimal('purfeetbs', 15, 3)->default(00.000);

            $table->decimal('purwtoth', 15, 3)->default(00.000);
            $table->Integer('purpcsoth')->default(0);
            $table->decimal('purfeetoth', 15, 3)->default(00.000);

            $table->decimal('purwttot', 15, 3)->default(00.000);
            $table->Integer('purpcstot')->default(0);
            $table->decimal('purfeettot', 15, 3)->default(00.000);

            $table->decimal('length',8,3)->default(0);

            $table->decimal('dtyrate', 15, 3)->default(00.000);
            $table->decimal('gdsprice', 15, 3)->default(00.000);
            $table->decimal('invsrate', 15, 3)->default(00.000);
            $table->smallInteger('bundle1')->default(0);
            $table->smallInteger('bundle2')->default(0);

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
        Schema::dropIfExists('purchasing_details');
    }
}
