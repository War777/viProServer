<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

//Clase modelo para los giros comerciales

class Trading extends Model
{

	use SoftDeletes;
	
	protected $table = 'tradings';

	protected $fillable = [

    	'description'

    ];

    protected $dates = ['deleted_at'];

}
