<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Own\Own;

use App\Rate;

//Controlador para las tarifas
class RatesController extends Controller
{

	/**
	*
	* Funcion para mostrar las tarifas disponible
	* @return View rates
	*
	*/

	public function displayGetRates(){

		return $this->displayRates('', '');

	}

	/**
	*
	* Funcion que extrae los datos de las tarifas para pasarlos a la vista
	* @return view rates
	*
	*/

	public function displayRates($message, $class){

		$tradingsQuery = 'select id as value, description as label from tradings;';

		$tradings = Own::queryToArray($tradingsQuery);

		$zonesQuery = 'select id as value, description as label from zones;';

		$zones = Own::queryToArray($zonesQuery);

		$localValues = array(

			['value' => '1', 'label' => 'Si'],
			['value' => '0', 'label' => 'No'],

		);

		$query = "select 
				    r.idTrading as 'idTrading',
				    t.description as 'trading',
				    r.idZone as 'idZone',
				    z.description as 'zone',
				    r.isLocal as 'isLocal',
				    r.baseRate as 'baseRate',
				    r.perMeterRate as 'perMeterRate',
				    r.comments as 'comments',
				    r.created_at as 'created_at',
				    r.updated_at as 'updated_at',
				    r.deleted_at as 'deleted_at'
				FROM
				    rates r
				        JOIN
				    tradings t ON r.idTrading = t.id
				        JOIN
				    zones z ON r.idZone = z.id;";

		$rates = Own::queryToArray($query);

		$data = array(

			'message' => $message,
			'class' => $class,
			'tradings' => $tradings,
			'zones' => $zones,
			'rates' => $rates,
			'localValues' => $localValues

		);

		return view('rates', $data);

	}

	/**
	*
	* Funcion para agregar alguna tarifa
	* @param Request request
	* @return View rates
	*
	*/

	public function addRate(Request $request){

		$inputs = $request->toArray();

		$rate = new Rate;

		$rate->idTrading = $inputs['idTrading'];
		$rate->idZone = $inputs['idZone'];
		$rate->isLocal = $inputs['isLocal'];
		$rate->baseRate = $inputs['baseRate'];
		$rate->perMeterRate = $inputs['perMeterRate'];
		$rate->comments = $inputs['comments'];

		$message = '';
		$class = '';

		try{

			$status = $rate->save();

			if($status == 1){

				$message = 'Tarifa agregada con exito!';
				$class = 'alert-success';

			}

		} catch(\Illuminate\Database\QueryException $e){

			$message = 'Entrada duplicada';
			$class = 'alert-danger';

		}

		return $this->displayRates($message, $class);



	}


}
