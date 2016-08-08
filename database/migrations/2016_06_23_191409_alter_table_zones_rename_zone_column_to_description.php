<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableZonesRenameZoneColumnToDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Renombramineto de la columna
        Schema::table('zones', function($table){

            $table->renameColumn('zone', 'description');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Reversion del nombramiento
        Schema::table('zones', function($table){

            $table->renameColumn('description', 'zone');

        });
    }
}
