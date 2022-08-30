<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblecontracttransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblecontracttrans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tblecontractmaster_id');
            $table->integer('transid');
            $table->smallinteger('brandid')->nullable();
            $table->smallinteger('bundle1');
            $table->smallinteger('pcspbundle1');
            $table->smallinteger('bundle2')->nullable();
            $table->smallinteger('pcspbundle2')->nullable();
            $table->smallinteger('bundle3')->nullable();
            $table->smallinteger('pcspbundle3')->nullable();
            $table->decimal('gdswt', 10, 4);
            $table->decimal('gdsprice', 12, 4);
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
        Schema::dropIfExists('tblecontracttrans');
    }
}
