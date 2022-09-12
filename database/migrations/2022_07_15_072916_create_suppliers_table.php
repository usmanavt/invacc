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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('source_id');
            $table->string('title',100);
            $table->string('nick',50)->nullable();
            $table->text('address')->nullable();
            $table->string('phoneoff',30)->nullable();
            $table->string('phoneres',30)->nullable();
            $table->string('fax',30)->nullable();
            $table->string('email',40)->nullable();
            $table->smallInteger('status')->default(1); // 1-Active , 0-Deactive
            $table->decimal('obalance',15,2)->nullable();
            $table->string('ntn',30)->nullable();
            $table->string('stax',30)->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
