<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUsersAddSoftDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creacion de columna de eliminacion simbolica
        Schema::table('users', function($table){

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
        //Eliminacion de la columna de eliminacion simbolica
        Schema::table('users', function($table){

            $table->dropColumn('deleted_at');

        });
    }
}
