<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMaps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creacion de la tabla de mapeos
        Schema::create('maps', function(Blueprint $table){

            $table->increments('id');
            $table->integer('idCharge');
            $table->string('file');
            $table->timeStamps();

        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Destruccion de la tabla de
        Schema::drop('maps');
    }
}
