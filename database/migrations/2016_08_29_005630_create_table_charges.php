<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        //Creacion de la tabla de cargos
        Schema::create('charges', function(Blueprint $table){

            $table->increments('id');
            $table->integer('idMerchant');
            $table->integer('idTrading');
            $table->integer('idZone');
            $table->integer('year');

            $table->tinyInteger('frontLength');
            $table->tinyInteger('wideLength');

            $table->tinyInteger('lightsOral');
            $table->tinyInteger('lightsReal');

            $table->integer('meterCharge');
            $table->integer('metersCharge');

            $table->integer('lightCharge');
            $table->integer('lightsCharge');

            $table->integer('totalCharge');

            $table->boolean('isChecked');
            $table->integer('score');
            $table->longText('notes');

            $table->binary('randomKey');

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
        
        //Desctruccion de la tabla de cargos
        Schema::drop('charges');

    }
}
