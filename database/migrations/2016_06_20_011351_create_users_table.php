<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            
            $table->increments('id');
            
            $table->string('names', 100);
            $table->string('lastName', 100);
            $table->string('secondName', 100);
            $table->date('birthDate');
            $table->string('password');
            $table->string('email');
            $table->string('phone', 10);
            $table->boolean('whatsapp');
            $table->string('curp', 8);
            $table->string('street', 100);
            $table->text('gmap');
            $table->rememberToken();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}