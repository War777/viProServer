<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creacion de la tabla de Zonas
        Schema::create('zones', function(Blueprint $table){

            $table->increments('id');
            $table->string('zone', 50)->unique();
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
        //Destruccion de la tabla de zonas
        Schema::drop('zones');
    }
}
