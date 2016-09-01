<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Clase modelo de los privilegios
class Privilege extends Model
{

	protected $table = 'privileges';

	protected $fillable = [

		'idUser',
		'idMenu',
		'read',
		'write'

	];

}
