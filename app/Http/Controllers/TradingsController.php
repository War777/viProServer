<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Own\Own;

use App\Trading;

use App\Rate;

use DB;


//Clase controladora de las categorias de comerciantes
class TradingsController extends Controller
{

    /**
    *
    * Funcion para mostrar las cetegorias disponibles sin parametros
    * @return View tradings
    *
    */

    public function displayGetTradings(){

       return $this->displayTradings('', '');

    }

    /**
	*
	* Funcion para mostrar las cetegorias disponibles
	* @return View tradings
	*
    */

    public function displayTradings($message, $class){

    	$query = "SELECT
            id as '+Id', 
            description as 'Descripcion', 
            created_at as 'F. Creacion .tc' 
            FROM tradings
            WHERE deleted_at IS NULL;";

    	$tradings = Own::queryToArray($query);

    	return view('tradings', ['tradings' => $tradings, 'message' => $message, 'class' => $class]);

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

    	return $this->displayTradings($message, $class);

    }

    /**
    *
    * Funcion para eliminar un giro comercial
    * @param Request
    * @return View
    *
    */

    public function deleteTrading(Request $request){

        $inputs = $request->toArray();          //Obtenemos las entradas

        $message = '';                          //Declaramos los parametros
        $class = '';

        if(isset($inputs['id'])){               //Verificamos que exista un id

            $trading = Trading::find($inputs['id']);  //Ubicamos la zona

            if(isset($trading)){                   //Verificamos que exista la zona

                $trading->delete();                //Eliminamos la zona

                Rate::where('idTrading', $inputs['id'])->delete(); //Asi mismo eliminamos los cargos

                $message = 'Giro eliminado con exito!'; //Modificamos los parametros
                $class = 'bg-info';

            }

        }

        return $this->displayTradings($message, $class);

    }

}
