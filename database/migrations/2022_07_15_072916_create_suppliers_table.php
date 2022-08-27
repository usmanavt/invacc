<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblesupplier', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('scode')->unique();
            $table->string('sname',100);
            $table->string('snname',50)->nullable();
            $table->text('spaddress')->nullable();
            $table->string('sphoneoff',30)->nullable();
            $table->string('sphoneres',30)->nullable();
            $table->string('sfax',30)->nullable();
            $table->string('semail',40)->nullable();
            $table->string('sstatus',15);
            $table->integer('obalance')->nullable();
            $table->string('ntnno',30)->nullable();
            $table->string('staxNo',30)->nullable();
            $table->smallInteger('srcId')->default(1);
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
        Schema::dropIfExists('tblesupplier');
    }
}
