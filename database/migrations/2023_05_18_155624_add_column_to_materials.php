<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->decimal('qtykg', 10, 2)->default(0.00);
            $table->decimal('qtypcs', 10, 2)->default(0.00);
            $table->decimal('qtyfeet', 10, 2)->default(0.00);
            $table->decimal('qtykgrt', 10, 2)->default(0.00);
            $table->decimal('qtypcsrt', 10, 2)->default(0.00);
            $table->decimal('qtyfeetrt', 10, 2)->default(0.00);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            //
        });
    }
}
