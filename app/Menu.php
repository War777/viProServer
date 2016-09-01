<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//Clase modelo para los menus
class Menu extends Model
{

	use SoftDeletes;
	
	protected $table = 'menus';

	protected $fillable = [

		'name',
		'target',
		'hasSubmenus',
		'idParent'

	];

	protected $dates = ['deleted_at'];

}
