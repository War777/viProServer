<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMerchantsAddRandomKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creacion de la columna de clave unica
        Schema::table('merchants', function(Blueprint $table){

            $table->binary('randomKey')->after('score');
            $table->bigInteger('phone')->change();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Destruccion de la columna llave
        Schema::table('merchants', function(Blueprint $table){

            $table->dropColumn('randomKey');
            $table->integer('phone')->change();

        });
    }
}
