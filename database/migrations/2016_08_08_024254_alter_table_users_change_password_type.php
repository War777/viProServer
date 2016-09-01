<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUsersChangePasswordType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Cambio del password de texto a blob
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
        
        //Cambio del password de blob a texto
        Schema::table('users', function($table){

            $table->string('password')->change();

        });

    }

}
