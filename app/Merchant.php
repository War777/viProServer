<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Clase modelo de la tabla comerciantes
class Merchant extends Model
{

	protected $table = 'merchants';

	protected $fillable = [

		'names',
		'firstName',
		'lastName',
		'isLocal',
		'phone',
		'idTrading',
		'idZone',
		'incomeType',
		'wideLength',
		'frontLength',
		'spotLightsOral',
		'spotLightsReal',
		'baseRate',
		'perMeterRate',
		'cfeMeterRate',
		'total',
		'isChecked',
		'score'

	];

	public function getFullName(){

		return $this->firstName . ' ' . $this->lastName . ' ' . $this->names;

	}

}
