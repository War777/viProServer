<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMerchantsDropChargesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Destruccion de las columntas de cargos
        Schema::table('merchants', function($table){

            $table->dropColumn(
                [
                    'idZone',
                    'wideLength',
                    'frontLength',
                    'spotLightsOral',
                    'spotLightsReal',
                    'baseRate',
                    'perMeterRate',
                    'cfeMeterRate',
                    'total',
                    'isChecked',
                    'score',
                    'randomKey'
                ]
            );

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
