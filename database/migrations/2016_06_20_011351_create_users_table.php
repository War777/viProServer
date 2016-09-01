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
            $table->char('gender', 1);
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone', 10)->unique();
            $table->boolean('whatsapp');
            $table->string('curp', 18)->unique();
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