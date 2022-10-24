<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHscodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hscodes', function (Blueprint $table) {
            $table->id();
            $table->string('hscode', 25);
            $table->decimal('cd', 8, 3)->nullable();
            $table->decimal('st', 8, 3)->nullable();
            $table->decimal('rd', 8, 3)->nullable();
            $table->decimal('acd', 8, 3)->nullable();
            $table->decimal('ast', 8, 3)->nullable();
            $table->decimal('it', 8, 3)->nullable();
            $table->decimal('wse', 8, 3)->nullable();
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
        Schema::dropIfExists('hscodes');
    }
}
