<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //Construccion de la tabla de giros comerciales
        Schema::create('tradings', function(Blueprint $table){

            $table->increments('id');
            $table->string('description', 100)->unique();
            $table->timestamps();
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
        //Destruccion de la tabla de giros comerciales
        Schema::drop('tradings');

    }
}
