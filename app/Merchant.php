<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

//Clase modelo de la tabla comerciantes
class Merchant extends Model
{

	use SoftDeletes;

	protected $table = 'merchants';

	protected $fillable = [

		'names',
		'firstName',
		'lastName',
		'isLocal',
		'phone',
		'idTrading',
		'incomeType'
		
	];

	protected $dates = ['deleted_at'];

	public function getFullName(){

		return $this->firstName . ' ' . $this->lastName . ' ' . $this->names;

	}

}
