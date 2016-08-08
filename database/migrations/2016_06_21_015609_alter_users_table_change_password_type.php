<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableChangePasswordType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Cambio del campo de password de texto a blob
        Schema::table('users', function($table){

            $table->binary('password')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Reversion del cambio
        Schema::table('users', function($table){

            $table->string('password')->change();

        });
    }
}
