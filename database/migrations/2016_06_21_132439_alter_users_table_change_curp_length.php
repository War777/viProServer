<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableChangeCurpLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Cambio de longitud de la curp
        Schema::table('users', function($table){

            $table->string('curp', 18)->change();
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Cambio de longitud de la curp
        Schema::table('users', function($table){

            $table->string('curp', 8)->change();
        
        });
    }
}
