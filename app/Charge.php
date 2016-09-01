<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Clase modelo para los cargos
class Charge extends Model
{

	protected $table = 'charges';

	protected $fillable = [

		'idMerchant',
		'idZone',
		'year',

		'frontLength',
		'wideLength',
		
		'lightsOral',
		'lightsReal',
		
		'meterCharge',
		'metersCharge',
		
		'lightCharge',
		'lightsCharge',
		
		'totalCharge',
		
		'isChecked',
		'score',
		'notes'

	];

}
