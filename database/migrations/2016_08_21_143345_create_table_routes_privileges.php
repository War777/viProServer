<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRoutesPrivileges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creacion de la tabla de privilegios
        Schema::create('privileges', function(Blueprint $table){

            $table->increments('id');
            $table->integer('idUser');
            $table->integer('idMenu');
            $table->boolean('read');
            $table->boolean('write');
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
        //Destruccion de la tabla de privilegios
        Schema::drop('privileges');
    }
}
