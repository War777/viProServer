<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Clase modelo para los giros comerciales

class Trading extends Model
{
	
	protected $table = 'tradings';

	protected $fillable = [

    	'description'

    ];

}
