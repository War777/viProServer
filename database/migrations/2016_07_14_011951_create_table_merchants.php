<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMerchants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creacion de la tabla de comerciantes
        Schema::create('merchants', function(Blueprint $table){

            $table->increments('id');

            $table->string('names', 100);
            $table->string('firstName', 100);
            $table->string('lastName', 100);

            $table->boolean('isLocal');
            $table->integer('phone')->unique();

            $table->integer('idTrading');
            $table->integer('idZone');
            $table->string('incomeType', 50);

            $table->tinyInteger('wideLength');
            $table->tinyInteger('frontLength');
            
            $table->tinyInteger('spotLightsOral');
            $table->tinyInteger('spotLightsReal');
            
            $table->integer('baseRate');
            $table->integer('perMeterRate');
            $table->integer('cfeMeterRate');
            $table->integer('total');
            $table->boolean('isChecked');
            $table->tinyInteger('score');

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
        //Destruccion de la tabla de comerciantes
        Schema::drop('merchants');
    }
}
