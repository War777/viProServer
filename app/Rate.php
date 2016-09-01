<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


//Clase modelo para las tarifas
class Rate extends Model
{
    use SoftDeletes;

	protected $table = 'rates';

	protected $fillable = [
		
		'idTrading',
		'idZone',
		'isLocal',
		'meterCharge',
		'comment'
		
	];

	protected $dates = ['deleted_at'];



}
