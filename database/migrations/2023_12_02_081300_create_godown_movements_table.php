<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGodownMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('godown_movements', function (Blueprint $table) {
            $table->id();
            $table->date('stodate');
            $table->smallInteger('stono')->default(0);
            $table->tinyInteger('fromg')->default(0);
            $table->tinyInteger('tog')->default(0);
            $table->decimal('tqtywt', 12, 2)->default(00.00);
            $table->decimal('tqtypcs', 12, 1)->default(00.00);
            $table->decimal('tqtyfeet', 12, 2)->default(00.00);

            $table->decimal('bqtywt', 12, 2)->default(00.00);
            $table->decimal('bqtypcs', 12, 1)->default(00.00);
            $table->decimal('bqtyfeet', 12, 2)->default(00.00);

            $table->Integer('goodsval')->default(0);
            $table->string('mremarks', 200)->nullable();

            $table->tinyInteger('clrldstatus')->default(0);
            $table->date('clrddate')->nullable();
            $table->date('clrdid')->default(0);


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
        Schema::dropIfExists('godown_movements');
    }
}
