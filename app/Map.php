<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Clase modelo de los mapeos
class Map extends Model
{

	protected $table = 'maps';

	protected $fillable = [

		'idCharge',
		'file'

	];

	

}
