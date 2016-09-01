<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creacion de la tabla de tarifas
        Schema::create('rates', function(Blueprint $table){

            $table->increments('id');
            $table->integer('idTrading');
            $table->integer('idZone');
            $table->boolean('isLocal');
            $table->integer('meterCharge');
            $table->string('comments', 100)->nullable();

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Eliminacion de la tabla de tarifas
        Schema::drop('rates');
    }
}
