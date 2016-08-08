<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


//Clase modelo para las tarifas
class Rate extends Model
{
    
	protected $table = 'rates';

	protected $fillable = [
		
		'idTrading',
		'idZone',
		'isLocal',
		'baseRate',
		'perMeterRate',
		'comment'
		
	];

}
