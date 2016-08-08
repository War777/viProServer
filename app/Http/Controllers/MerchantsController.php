<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Own\Own;

use App\Merchant;

use DB;

use QrCode;

use Hash;

use PDF;

//Clase controladora de comerciantes
class MerchantsController extends Controller
{

	public function displayGetMerchants(){

		return $this->displayMerchants('', '');

	}

	public function displayMerchants($message, $class){

		$query = "SELECT m.id,
			    m.names,
			    m.firstName,
			    m.lastName,
			    m.isLocal,
			    m.phone,
			    m.idTrading,
			    t.description as 'tradingDescription',
			    m.idZone,
			    z.description as 'zoneDescription',
			    m.incomeType,
			    m.wideLength,
			    m.frontLength,
			    m.spotLightsOral,
			    m.spotLightsReal,
			    m.baseRate,
			    m.perMeterRate,
			    m.cfeMeterRate,
			    m.total,
			    m.isChecked,
			    m.score,
			    m.created_at,
			    m.updated_at,
			    m.deleted_at
			FROM merchants m
			JOIN tradings t 
			ON m.idTrading = t.id
			JOIN zones z
			ON m.idZone = z.id
			ORDER BY m.id;";

		$merchants = Own::queryToArray($query);

		$queryTradings = "";

		$localValues = array(

			['value' => '1', 'label' => 'Si'],
			['value' => '0', 'label' => 'No'],

		);

		$queryTradings = "select r.idTrading as 'value', t.description as 'label'
			from rates r
			inner join tradings t
			on r.idTrading = t.id;";

		$tradingsValues = Own::queryToArray($queryTradings);

		$queryZones = "select r.idZone as 'value', z.description as 'label'
			from rates r
			inner join zones z
			on r.idZone= z.id;";

		$zonesValues = Own::queryToArray($queryZones);

		$incomeValues = array(
			['value' => 'Variable', 'label' => 'Variable'],
			['value' => 'Fijo', 'label' => 'Fijo'],
		);

		$data = array(
			'merchants' => $merchants,
			'message' => $message,
			'class' => $class,
			'localValues' => $localValues,
			'tradingsValues' => $tradingsValues,
			'zonesValues' => $zonesValues,
			'incomeValues' => $incomeValues
		);

		

		return view('merchants', $data);

	}

	/**
	*
	* Funcion que agregag un comerciante dentro de la base de datos
	* @param Requst request
	* @return View merchants
	*
	*/
	public function addMerchant(Request $request){

		$queryRate = "select baseRate, perMeterRate
			from rates
			where idTrading = 1
			and idZone = 2
			and isLocal = 0;";

		$rateValues = Own::queryToSingleArray($queryRate);

		$queryCfeCost = "select value from variables where name = 'perMeterCfeCost';";

		$cfePerMeterCost = Own::queryToData($queryCfeCost); 

		$inputs = $request->toArray();

		$merchant = new Merchant;

		$merchant->names = $inputs['names'];
		$merchant->firstName = $inputs['firstName'];
		$merchant->lastName = $inputs['lastName'];
		$merchant->isLocal = $inputs['isLocal'];
		$merchant->phone = $inputs['phone'];
		$merchant->idTrading = $inputs['idTrading'];
		$merchant->idZone = $inputs['idZone'];
		$merchant->incomeType = $inputs['incomeType'];
		$merchant->wideLength = $inputs['wideLength'];
		$merchant->frontLength = $inputs['frontLength'];
		$merchant->spotLightsOral = $inputs['spotLightsOral'];
		$merchant->spotLightsReal = $inputs['spotLightsOral'];
		$merchant->baseRate = $rateValues['baseRate'];
		$merchant->perMeterRate = $rateValues['perMeterRate'];
		$merchant->cfeMeterRate = $cfePerMeterCost;
		$merchant->total = $rateValues['baseRate'] 
			+ ($inputs['wideLength'] * $rateValues['perMeterRate']) 
			+ ($inputs['wideLength'] * $cfePerMeterCost);
		$merchant->isChecked = '0';
		$merchant->score = '5';
		$merchant->randomKey = str_replace(['/', '\\', '.'], "-", Hash::make(str_random(20)));

		$message = '';
		$class = '';

		try{

			$status = $merchant->save();

			if($status == 1){

				$this->createQrCode($merchant);

				$message = 'Comerciante agregado con exito agregada con exito!';
				$class = 'alert-success';


			}

		} catch(\Illuminate\Database\QueryException $e){

			$message = 'Entrada duplicada';
			$class = 'alert-danger';

		}

		return $this->displayMerchants($message, $class);

	}

	/**
	*
	* Funcion que imprime el recibo de pago del comerciante
	* @param Integer id
	*
	*/

	public function printReceipt(Request $request){

		$inputs = $request->toArray();
		
		$id = $inputs['id'];

		if(isset($id)){

			$merchantQuery = "SELECT m.id,
				    m.names,
				    m.firstName,
				    m.lastName,
				    m.isLocal,
				    m.phone,
				    m.idTrading,
				    t.description as 'tradingDescription',
				    m.idZone,
				    z.description as 'zoneDescription',
				    m.incomeType,
				    m.wideLength,
				    m.frontLength,
				    m.spotLightsOral,
				    m.spotLightsReal,
				    m.baseRate,
				    m.perMeterRate,
				    m.cfeMeterRate,
				    m.total,
				    m.isChecked,
				    m.score,
				    m.randomKey,
				    m.created_at,
				    m.updated_at,
				    m.deleted_at
				FROM merchants m
				JOIN tradings t 
				ON m.idTrading = t.id
				AND m.id = " . $id . "
				JOIN zones z
				ON m.idZone = z.id;";

			$merchant = Own::queryToSingleArray($merchantQuery);

			$data = array(
				'merchant' => $merchant
			);

			$pdfReceipt = PDF::loadView('printReceipt', $data);

			return $pdfReceipt->stream();
			// return view('printReceipt', $data);

		} else {

			return displayMerchants('Comerciante no existente <br> Favor de verificar el id.', 'bg-danger');

		}

	}

	/**
	*
	* Funcion que crea los codigos QR dado un id.
	* @param Merchant merchant
	*
	*/

	public function createQrCode($merchant){

		if(isset($merchant)){

			$path = 'resources/qrcodes/';
			$url = 'https://localhost/laravel/quickCheck?key=' . $merchant->randomKey;
			$file = '' . $merchant->randomKey . '.svg';
			
			QrCode::format('png');
			QrCode::size(300);
			QrCode::generate($url, $path . $file);

		} else {

			return displayMerchants('Comerciante no existente <br> Favor de verificar el id.', 'bg-danger');

		}

	}


}
