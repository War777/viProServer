<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableAddGengerColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Agregamos la columna de genero
        Schema::table('users', function($table){

            $table->char('gender', 1)->after('birthDate');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Eliminamos la columna
        Schema::table('users', function($table){

            $table->dropColumn('gender');

        });
    }
}
