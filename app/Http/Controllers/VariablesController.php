<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Own\Own;

use App\Variable;

//Clase controladora de las variables del entorno
class VariablesController extends Controller
{

	public function displayGetVariables(){

		return $this->displayVariables('', '');

	}

	public function displayVariables($message, $class){

		$query = "select * from variables;";

		$variables = Own::queryToArray($query);

		$data = array(
			'variables' => $variables,
			'message' => $message,
			'class' => $class
		);

		return view('variables', $data);

	}

	public function addVariable(Request $request){

		$inputs = $request->toArray();

		$variable = new Variable;

		$variable->name = $inputs['name'];
		$variable->value = $inputs['value'];

		$message = '';
		$class = '';

		try{

			$status = $variable->save();

			if($status == 1){

				$message = 'Variable agregada con exito!';
				$class = 'alert-success';

			}

		} catch(\Illuminate\Database\QueryException $e){

			$message = 'Entrada duplicada';
			$class = 'alert-danger';

		}

		return $this->displayVariables($message, $class);

	}



}
