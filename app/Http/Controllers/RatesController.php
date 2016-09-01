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

		$tradingsQuery = 'select id as value, description as label from tradings where deleted_at is null;';

		$tradings = Own::queryToArray($tradingsQuery);

		$zonesQuery = 'select id as value, description as label from zones where deleted_at is null;';

		$zones = Own::queryToArray($zonesQuery);

		$localValues = array(

			['value' => '1', 'label' => 'Si'],
			['value' => '0', 'label' => 'No'],

		);

		$query = "select 
					r.id as '+Id',
				    t.description as 'Giro',
				    z.description as 'Zona',
				    r.isLocal as '!Es local',
				    r.meterCharge as '\$\$\$Tarifa por metro',
				    r.comments as 'Comentarios',
				    r.created_at as 'F. Creacion .tc'
				FROM
				    rates r
				        JOIN
				    tradings t ON r.idTrading = t.id
				        JOIN
				    zones z ON r.idZone = z.id
				    AND r.deleted_at is null;";

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

		$rate = $this->firstOrNewRate($inputs);

		$message = '';
		$class = '';

		if(isset($rate)){

			$message = 'Tarifa agregada con exito!';
			$class = 'alert-success';

		}

		return $this->displayRates($message, $class);

	}

	/**
	*
	* Funcion para eliminar una tarifa
	* @param Request
	* @return view
	*
	*/

	public function deleteRate(Request $request){

		$inputs = $request->toArray();

		$message = '';
		$class = '';

		if(isset($inputs['id'])){

			$rate = Rate::find($inputs['id']);

			if(isset($rate)){

				$rate->delete();

				$message = 'Tarifa eliminada!';
				$class = 'bg-info';

			}

		}

		return $this->displayRates($message, $class);

	}

	/**
	*
	* Funcion para mostrar la plantilla de actualizacion
	* @param Request
	* @return View
	*
	*/

	public function displayUpdateBlade(Request $request){

		$inputs = $request->toArray();

		if(isset($inputs['id'])){

			$rateQuery = "SELECT 
					r.id,
					r.idTrading,
				    t.description as 'trading',
				    r.idZone,
				    z.description as 'zone',
				    r.isLocal,
				    r.meterCharge,
				    r.comments
				FROM
				    rates r
				        JOIN
				    tradings t ON r.idTrading = t.id
				        JOIN
				    zones z ON r.idZone = z.id
				    AND r.deleted_at is null
				    AND r.id = " . $inputs['id'] . ";";

			$rate = Own::queryToSingleArray($rateQuery);

			if(isset($rate)){

				return view('updateRate', ['rate' => $rate]);

			}

		} else {

			return $this->displayRates('', '');

		}

	}

	/**
	*
	* Funcion para actualizar una tarifa
	* @param Request
	* @return View
	*
	*/

	public function updateRate(Request $request){

		$inputs = $request->toArray();

		$rate = $this->firstOrNewRate($inputs);

		$message = '';
		$class = '';

		if(isset($rate)){

			$message = 'Tarifa actualizada con exito!';
			$class = 'bg-info';

		}

		return $this->displayRates($message, $class);

	}

	/**
   	*
   	* Funcion para crear o actualizar una zonas
   	* @param Array
   	*
   	*/

   	public function firstOrNewRate($attributes){

   		$rate = Rate::withTrashed()->firstOrNew(
			[
				'idTrading' => $attributes['idTrading'],
				'idZone' => $attributes['idZone'],
				'isLocal' => $attributes['isLocal'],

   			]
		);
		
		$rate->meterCharge = $attributes['meterCharge'];
		$rate->comments = $attributes['comments'];
   		$rate->deleted_at = null;
   		$rate->save();

   		return $rate;

   	}

}
