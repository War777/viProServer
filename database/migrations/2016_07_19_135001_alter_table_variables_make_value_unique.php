<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVariablesMakeValueUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Modificacion de la columna de nombre como unica
        Schema::table('variables', function($table){

            $table->unique('name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Reversion de la culunma
        Schema::table('variables', function($table){

            $table->dropUnique('variables_name_unique');

        });
    }
}
