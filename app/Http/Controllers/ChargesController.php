<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Charge;

use App\Merchant;

use App\Map;

use App\Own\Own;

//Clase controladora de los cargos
class ChargesController extends Controller
{


	/**
	*
	* Funcion para mostrar la vista de mapeo
	* @return View
	*
	*/

	public function displayMapOutBlade(){

		return view('mapOutCharge');

	}

	/**
	*
	* Funcion para mostrar el cargo a mapear
	* @return View
	*
	*/

	public function displayChargeToMap(Request $request){

		$inputs = $request->toArray();

		return $this->displayCharge($inputs['id']);

	}

	/**
	*
	* Funcion para mostrar los datos a mapear
	* @return View
	*
	*/

	public function displayCharge($id){

		$charge = Charge::find($id); 

		if(isset($charge)){

			$merchant = Merchant::find($charge->idMerchant);

			$queryFiles = "SELECT id, file FROM maps WHERE idCharge = " . $charge->id . ";";

			$maps = Own::queryToArray($queryFiles);

			$data = array(

				'charge' => $charge,
				'merchant' => $merchant,
				'maps' => $maps

			);

			return view('mapOutCharge', $data);

		} else {

			$data = array(

				'message' => 'Cargo no encontrado, favor de intentar con otro folio',
				'class' => 'bg-danger'

			);

			return view('mapOutCharge', $data);			
			
		}

	}

	/**
	*
	* Funcion para mostrar los datos a mapear
	* @return View
	*
	*/

	public function mapOutCharge(Request $request){

		$inputs = $request->toArray();

		$mapName = $inputs['idCharge'] . "-" . date('YmdHis') . ".jpg";

		$request->file('map')->move('resources/maps', $mapName);

		$map = new Map;

		$map->idCharge = $inputs['idCharge'];
		$map->file = $mapName;

		$map->save();

		return $this->displayCharge($inputs['idCharge']);

	}

	/**
	*
	* Funcion para mostrar los datos a mapear
	* @return View
	*
	*/

	public function mapOutChargeByQr(Request $request){

		$inputs = $request->toArray();

		$mapName = $inputs['idCharge'] . "-" . date('YmdHis') . ".jpg";

		$request->file('map')->move('resources/maps', $mapName);

		$map = new Map;

		$map->idCharge = $inputs['idCharge'];
		$map->file = $mapName;

		$map->save();

		return $this->quickCheck($request);

	}

	/**
	*
	* Funcion para eliminar una evidencia
	* @param Request
	* @return View
	*
	*/

	public function removeMap(Request $request){

		$inputs = $request->toArray();

		$map = Map::find($inputs['id']);

		if(isset($map)){

			unlink('resources/maps/' . $map->file);
			
			$map->delete();


		}
		
		return $this->displayCharge($inputs['idCharge']);

	}

	/**
	*
	* Funcion para eliminar una evidencia
	* @param Request
	* @return View
	*
	*/

	public function removeMapByQr(Request $request){

		$inputs = $request->toArray();

		$map = Map::find($inputs['id']);

		if(isset($map)){

			unlink('resources/maps/' . $map->file);
			
			$map->delete();

		}
		
		return $this->quickCheck($request);

	}

	/**
	*
	* Funcion para realizar la
	* @param Request
	* @return View
	*
	*/

	public function quickCheck(Request $request){

		$inputs = $request->toArray();

		if(isset($inputs['key'])){

			$chargeQuery = "select 

				c.id,
			    c.idMerchant,
			    
			    c.idTrading,
			    
			    
			    c.idZone,
			    
			    c.year,
			    c.frontLength,
			    c.wideLength,
			    c.lightsOral,
			    c.lightsReal,
			    c.meterCharge,
			    c.metersCharge,
			    c.lightCharge,
			    c.lightsCharge,
			    c.totalCharge,
			    c.isChecked,
			    c.randomKey,
			    c.score,
			    c.notes,
			    c.created_at
			 
			from charges c
			
			where c.randomKey = '" . $inputs['key'] . "';";

			$charge = Own::queryToSingleArray($chargeQuery);

			if(count($charge) > 0){

				$merchant = Merchant::find($charge['idMerchant']);

				$queryFiles = "SELECT id, file FROM maps WHERE idCharge = " . $charge['id'] . ";";

				$maps = Own::queryToArray($queryFiles);

				$data = array(

					'charge' => $charge,
					'merchant' => $merchant,
					'maps' => $maps

				);

				return view('quickCheck', $data);

			} else {

				return view('quickCheck');

			}

		}

	}

	/**
	*
	* Funcion para realizar la evaluacion del comerciante
	* @param Request
	* @return View
	*
	*/

	public function evaluateCharge(Request $request){

		$inputs = $request->toArray();

		$charge = Charge::find($inputs['id']);

		$charge->notes = $inputs['notes'];
		$charge->score = $inputs['score'];

		$charge->isChecked = 1;

		$charge->save();

		return $this->quickCheck($request);

	}


}
