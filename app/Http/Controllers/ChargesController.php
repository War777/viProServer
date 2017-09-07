<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Charge;

use App\Merchant;

use App\Map;

use App\Trading;

use App\Zone;

use App\Own\Own;

use App\Own\VariablesController;

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

	/**
	*
	* Funcion para mostrar la vista de la busqueda
	* @param Request
	* @return View
	*
	*/

	public function displaySearchByCharge(){

		return view('searchByCharge');

	}

	/**
	*
	* Funcion para mostrar los datos del comerciante de acuerdo al folio
	* @param Request
	* @return View
	*
	*/

	public function searchByCharge(Request $request){

		$inputs = $request->toArray();

		$charge = Charge::find($inputs['id']);

		$data = array();
		
		$message = '';
		$class = '';

		if(isset($charge)){

			$merchant = Merchant::find($charge->idMerchant);

			$trading = Trading::find($charge->idTrading);

			$zone = Zone::find($charge->idZone);

			if(isset($trading) == false){

				$message .= 'Tarifa no encontrada <br>';
				$class .= ' bg-danger';

			}

			if(isset($zone) == false){

				$message .= 'Zona no encontrada <br>';
				$class .= ' bg-danger';

			}

			$data['charge'] = $charge;
			$data['merchant'] = $merchant;
			$data['trading'] = $trading;
			$data['zone'] = $zone;

		} else {

			$message = 'Folio no encontrado <br>';
			$class = 'bg-danger';

		}

		$data['id'] = $inputs['id'];
		$data['message'] = $message;
		$data['class'] = $class;
		

		$data['tradingsValues'] = VariablesController::getTradingsArray();
		$data['zonesValues'] = VariablesController::getZonesArray();

		$data['lightCharge'] = VariablesController::getLightCharge();
		$data['currentIncrease'] = VariablesController::getCurrentIncrease();

		return view('searchByCharge', $data);

	}


}
