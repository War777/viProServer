<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Clase modelo para la tabla de variables
class Variable extends Model
{

	protected $table = 'variables';

	protected $fillable = [
		'name',
		'value'
	];

}
