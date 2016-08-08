<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Own\Own;

use App\Trading;

use DB;


//Clase controladora de las categorias de comerciantes
class TradingsController extends Controller
{
    
    /**
	*
	* Funcion para mostrar las cetegorias disponibles
	* @return View tradings
	*
    */

    public function displayTradings(){

    	$query = 'select * from tradings;';

    	$tradings = Own::queryToArray($query);

    	return view('tradings', ['tradings' => $tradings]);

    }

    /**
	*
	* Funcion para agregar una categoria a la base de datos
	* @param Request request
	* @return View tradings
	*
    */

    public function addTrading(Request $request){

    	$inputs = $request->toArray();					//Obtenemos los datos del formulario

    	$trading = new Trading;

    	$trading->description = $inputs['description'];

    	$message = '';
    	$class = '';

    	try {
    		
    		$status = $trading->save();

    		if($status == 1){

    			$message = 'Giro comercial agregado con exito!';
    			$class = 'alert-success';

    		}

    	} catch (\Illuminate\Database\QueryException $e) {
    		
    		$message = 'Entrada duplicada';
    		$class = 'alert-danger';

    	}
    	
    	$query = 'select * from tradings;';

    	$tradings = Own::queryToArray($query);

    	$data = array(
    		'tradings' => $tradings,
    		'message' => $message,
    		'class' => $class
		);

    	return view('tradings', $data);

    }

}
