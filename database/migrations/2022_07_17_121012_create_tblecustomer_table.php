<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblecustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblecustomer', function (Blueprint $table) {
            $table->id();
            $table->string('cname',100);
            $table->string('cnname',50)->nullable();
            $table->text('cpaddress')->nullable();
            $table->text('cdivraddress')->nullable();
            $table->text('contpaddress')->nullable();
            $table->string('cphoneoff',30)->nullable();
            $table->string('cphoneres',30)->nullable();
            $table->string('cfax',30)->nullable();
            $table->string('cemail',40)->nullable();
            $table->string('cstatus',15);
            $table->integer('obalance')->nullable();
            $table->string('ntnno',30)->nullable();
            $table->string('staxno',30)->nullable();
            $table->smallInteger('cop')->nullable();
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
        Schema::dropIfExists('tblecustomer');
    }
}
