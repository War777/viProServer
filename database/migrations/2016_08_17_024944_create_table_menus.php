<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creacion de la tabla de menus
        Schema::create('menus', function(Blueprint $table){

            $table->increments('id');
            $table->string('name', 50);
            $table->string('target', 50);
            $table->boolean('hasSubmenus');
            $table->integer('idParent')->nullable();
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
        //Destruccion de la tabla de menus
        Schema::drop('menus');
    }
}
