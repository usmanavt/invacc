<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningGodownStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opening_godown_stocks', function (Blueprint $table) {
            $table->id();
            $table->Integer('material_id')->default(0);
            $table->date('opdate');

            $table->decimal('ostkwte13', 15, 3)->default(00.000);
            $table->decimal('ostkpcse13', 15, 3)->default(00.000);
            $table->decimal('ostkfeete13', 15, 3)->default(00.000);

            $table->decimal('ostkwtgn2', 15, 3)->default(00.000);
            $table->decimal('ostkpcsgn2', 15, 3)->default(00.000);
            $table->decimal('ostkfeetgn2', 15, 3)->default(00.000);

            $table->decimal('ostkwtams', 15, 3)->default(00.000);
            $table->decimal('ostkpcsams', 15, 3)->default(00.000);
            $table->decimal('ostkfeetams', 15, 3)->default(00.000);

            $table->decimal('ostkwte24', 15, 3)->default(00.000);
            $table->decimal('ostkpcse24', 15, 3)->default(00.000);
            $table->decimal('ostkfeete24', 15, 3)->default(00.000);


            $table->decimal('ostkwtbs', 15, 3)->default(00.000);
            $table->decimal('ostkpcsbs', 15, 3)->default(00.000);
            $table->decimal('ostkfeetbs', 15, 3)->default(00.000);

            $table->decimal('ostkwtoth', 15, 3)->default(00.000);
            $table->decimal('ostkpcsoth', 15, 3)->default(00.000);
            $table->decimal('ostkfeetoth', 15, 3)->default(00.000);

            $table->decimal('ostkwttot', 15, 3)->default(00.000);
            $table->decimal('ostkpcstot', 15, 3)->default(00.000);
            $table->decimal('ostkfeettot', 15, 3)->default(00.000);


            $table->decimal('ocostwt', 15, 3)->default(00.000);
            $table->decimal('ocostpcs', 15, 3)->default(00.000);
            $table->decimal('ocostfeet', 15, 3)->default(00.000);

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
        Schema::dropIfExists('opening_godown_stocks');
    }
}
