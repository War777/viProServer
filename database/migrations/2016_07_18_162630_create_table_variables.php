<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVariables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creacion de la tabla de variables
        Schema::create('variables', function(Blueprint $table){

            $table->increments('id');
            $table->string('name', 100);
            $table->string('value', 100);
            $table->timeStamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        //Destruccion de la tabla de variables
        Schema::drop('variables');

    }
    
}
