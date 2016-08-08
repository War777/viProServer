<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableRatesAddPrimaryKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creacion de la llave primaria para la tabla de tarifas
        Schema::table('rates', function($table){

            $table->primary(['idTrading', 'idZone', 'isLocal']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Destruccion de la llave primaria
        Schema::table('rates', function($table){

            $table->dropPrimary(['idTrading', 'idZone', 'isLocal']);

        });
    }
}
