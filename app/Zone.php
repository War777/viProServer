<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//Clase modelo de las zonas
class Zone extends Model
{

    use SoftDeletes;

    protected $table = 'zones';

    protected $fillable = [

    	'description'

    ];

    protected $dates = ['deleted_at'];
    
}
