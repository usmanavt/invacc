<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGodownStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('godown_stock', function (Blueprint $table) {
            $table->id();
            $table->Integer('material_id')->default(0);

            $table->decimal('stkwte13', 15, 3)->default(00.000);
            $table->Integer('stkpcse13')->default(0);
            $table->decimal('stkfeete13', 15, 3)->default(00.000);

            $table->decimal('stkwtgn2', 15, 3)->default(00.000);
            $table->Integer('stkpcsgn2')->default(0);
            $table->decimal('stkfeetgn2', 15, 3)->default(00.000);

            $table->decimal('stkwtams', 15, 3)->default(00.000);
            $table->Integer('stkpcsams')->default(0);
            $table->decimal('stkfeetams', 15, 3)->default(00.000);

            $table->decimal('stkwte24', 15, 3)->default(00.000);
            $table->Integer('stkpcse24')->default(0);
            $table->decimal('stkfeete24', 15, 3)->default(00.000);


            $table->decimal('stkwtbs', 15, 3)->default(00.000);
            $table->Integer('stkpcsbs')->default(0);
            $table->decimal('stkfeetbs', 15, 3)->default(00.000);

            $table->decimal('stkwtoth', 15, 3)->default(00.000);
            $table->Integer('stkpcsoth')->default(0);
            $table->decimal('stkfeetoth', 15, 3)->default(00.000);

            $table->decimal('stkwttot', 15, 3)->default(00.000);
            $table->Integer('stkpcstot')->default(0);
            $table->decimal('stkfeettot', 15, 3)->default(00.000);


            $table->decimal('costwt', 15, 3)->default(00.000);
            $table->Integer('costpcs')->default(0);
            $table->decimal('costfeet', 15, 3)->default(00.000);








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
        Schema::dropIfExists('godown_stock');
    }
}
