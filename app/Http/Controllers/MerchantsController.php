<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Own\Own;

use App\Merchant;

use App\Charge;

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

		$query = "SELECT 
				m.id as '+id', 
				m.firstName as 'A. Paterno', 
			    m.lastName as 'A. Materno', 
			    m.names as 'Nombre(s)', 
			    m.isLocal as '!Es local', 
			    m.phone as 'Telefono .tr', 
			    t.description as 'Giro',
			    m.incomeType as 'Ingreso', 
			    m.created_at as 'F. Creacion .tc'
			FROM merchants m
			JOIN tradings t
			ON m.idTrading = t.id
			WHERE m.deleted_at IS NULL;";

		$merchants = Own::queryToArray($query);

		$data = array(
			'merchants' => $merchants,
			'message' => $message,
			'class' => $class
		);

		return view('merchants', $data);

	}

	/**
	*
	* Funcion que imprime el recibo de pago del comerciante
	* @param Integer id
	*
	*/

	public function printMerchantCharge(Request $request){

		$inputs = $request->toArray();
				
		$id = $inputs['id'];

		if(isset($id)){

			//
			$charge = Charge::find($inputs['id']);

			$merchant = Merchant::find($charge->idMerchant);

			$trading = Own::queryToData("SELECT description FROM tradings WHERE id = " . $merchant->idTrading. ";");

			$zone = Own::queryToData("SELECT description FROM zones WHERE id = " . $charge->idZone. ";");

			$data = array(
				'merchant' => $merchant,
				'charge' => $charge,
				'trading' => $trading,
				'zone' => $zone,
				'qrUrl' => Own::getQrUrl()
			);

			$pdfReceipt = PDF::loadView('printMerchantCharge', $data);

			// return view('printMerchantCharge', $data);

			return $pdfReceipt->stream();

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

	public function createQrCode($charge){

		if(isset($charge)){

			$queryDomain = "select value from variables where name = 'publicDomain';";

			$domain = Own::queryToData($queryDomain);

			$path = 'resources/qrcodes/';
			$url = $domain . '/quickCheck?key=' . $charge->randomKey;
			$file = '' . $charge->randomKey . '.png';
			
			QrCode::format('png');
			QrCode::margin(0);
			QrCode::errorCorrection('H');
			QrCode::size(170);

			QrCode::merge('/resources/qrcodes/400-min.png', .5);

			QrCode::generate($url, $path . $file);

		} else {

			return displayMerchants('Comerciante no existente <br> Favor de verificar el id.', 'bg-danger');

		}

	}

	/**
	*
	* Funcion para agregar al comerciante con recibo
	* @param Request request
	* @return view merchants
	*
	*/

	public function addMerchantWithReceipt(Request $request){

		$message = '';
		$class = '';

		$inputs = $request->toArray();
		
		$merchantExists = Own::queryToSingleArray("select * from merchants where phone = " . $inputs['phone'] . " and deleted_at is null");
		
		if(isset($merchantExists['phone'])){

			$data = array(

				'inputs' => $inputs,
				'message' => 'Comerciante ya existente, favor de intentar con otro numero de telefono',
				'class' => 'bg-danger',
				'inputs' => $inputs,
				'localValues' => $this->getLocalValues(),
				'tradingsValues' => $this->getTradingsArray(),
				'zonesValues' => $this->getZonesArray(),
				'incomeValues' => $this->getIncomeValues(),
				'lightCharge' => $this->getLightCharge(),
				'currentIncrease' => $this->getCurrentIncrease(),

			);

			return view('addReceiptMerchant', $data);

		}

		$merchant = $this->firstOrNewMerchant($inputs);



		$chargeAttributes = array(
			'idMerchant' => $merchant->id,
			'idZone' => $inputs['idZone'],
			'year' => date('Y'),
			'frontLength' => $inputs['frontLength'],
			'wideLength' => $inputs['wideLength'],
			'lightsOral' => $inputs['lightsOral'],
			'lightsReal' => $inputs['lightsOral'],
			'meterCharge' => ($inputs['lastMeterCharge'] + $inputs['currentIncrease']),
			'metersCharge' => ($inputs['lastMeterCharge'] + $inputs['currentIncrease']) * $inputs['wideLength'],
			'lightCharge' => $inputs['lightCharge'],
			'lightsCharge' => ($inputs['lightCharge'] * $inputs['lightsOral']),
			'totalCharge' =>  (($inputs['lastMeterCharge'] + $inputs['currentIncrease']) * $inputs['wideLength']) + ($inputs['lightCharge'] * $inputs['lightsOral']),
			'isChecked' => '0',
			'score' => '5',
			'notes' => $inputs['notes']
		);

		$message = 'Comerciante agregado con exito';
		$class = 'bg-success';

		$charge = $this->firstOrNewCharge($chargeAttributes);

		return $this->displayMerchants($message, $class);

	}

	/**
	*
	* Funcion para crear o actualizar un comerciante
	* @param Array attributes
	* @return Merchant merchant
	*
	*/

	public function firstOrNewMerchant($attributes){

		$merchant = Merchant::withTrashed()->firstOrNew(['phone' => $attributes['phone']]);

		$merchant->names = $attributes['names'];
		$merchant->firstName = $attributes['firstName'];
		$merchant->lastName = $attributes['lastName'];
		$merchant->isLocal = $attributes['isLocal'];
		$merchant->idTrading = $attributes['idTrading'];
		$merchant->incomeType = $attributes['incomeType'];

		$merchant->deleted_at = null;

		$merchant->save();

		return $merchant;

	}


	/**
	*
	* Funcion para crear o actualizar un cargo
	* @param Array attributes
	* @return Charge charge 
	*/
	
	public function firstOrNewCharge($attributes){

		$charge = Charge::firstOrNew(
			[
				'idMerchant' => $attributes['idMerchant'], 
				'year' => $attributes['year']
			]
		);

		$charge->idTrading = $attributes['idZone'];
		$charge->idZone = $attributes['idZone'];
		$charge->frontLength = $attributes['frontLength'];
		$charge->wideLength = $attributes['wideLength'];
		$charge->lightsOral = $attributes['lightsOral'];
		$charge->lightsReal = $attributes['lightsReal'];
		$charge->meterCharge = $attributes['meterCharge'];
		$charge->metersCharge = $attributes['metersCharge'];
		$charge->lightCharge = $attributes['lightCharge'];
		$charge->lightsCharge = $attributes['lightsCharge'];
		$charge->totalCharge = $attributes['totalCharge'];
		$charge->isChecked = $attributes['isChecked'];
		$charge->score = $attributes['score'];
		$charge->notes = $attributes['notes'];
		$charge->randomKey = str_replace(['/', '\\', '.'], "-", Hash::make(str_random(20)));

		$charge->save();

		$this->createQrCode($charge);

		return $charge;

	}

	/**
	*
	* Funcion para crear o actualizar un cargo
	* @param Array attributes
	* @return Charge charge 
	*
	*/
	public function addReceiptCharge(Request $request){

		$inputs = $request->toArray();

		$charge = new Charge;

		$chargeAttributes = array(
			'idMerchant' => $inputs['idMerchant'],
			'idTrading' => $inputs['idTrading'],
			'idZone' => $inputs['idZone'],
			'year' => date('Y'),
			'frontLength' => $inputs['frontLength'],
			'wideLength' => $inputs['wideLength'],
			'lightsOral' => $inputs['lightsOral'],
			'lightsReal' => $inputs['lightsOral'],
			'meterCharge' => ($inputs['lastMeterCharge'] + $inputs['currentIncrease']),
			'metersCharge' => ($inputs['lastMeterCharge'] + $inputs['currentIncrease']) * $inputs['wideLength'],
			'lightCharge' => $inputs['lightCharge'],
			'lightsCharge' => ($inputs['lightCharge'] * $inputs['lightsOral']),
			'totalCharge' =>  (($inputs['lastMeterCharge'] + $inputs['currentIncrease']) * $inputs['wideLength']) + ($inputs['lightCharge'] * $inputs['lightsOral']),
			'isChecked' => '0',
			'score' => '5',
			'notes' => $inputs['notes']
		);

		$charge = $this->addCharge($chargeAttributes);

		$request['id'] = $inputs['idMerchant'];
		$request['message'] = 'Cargo agregado con exito!';
		$request['class'] = 'bg-success';

		return $this->displayMerchantCharges($request);

	}

	/**
	*
	* Funcion para mostrar los cargos del comerciante
	* @param Request
	* @return view Charges
	*
	*/

	public function displayMerchantCharges(Request $request){

		$inputs = $request->toArray();

		$message = '';
		$class = '';

		if(isset($inputs['message'])){

			$message = $inputs['message'];

		}

		if(isset($inputs['class'])){

			$class = $inputs['class'];

		}

		$merchant = Merchant::find($inputs['id']);

		$queryCharges = "SELECT 
			c.id as '+id',
			c.year as 'A&ntilde;o .tc',
		    z.description as 'Zona',
		    c.frontLength as '#M. Frente',
		    c.wideLength as '#M. Largo',
		    c.lightsOral as '#Focos',
		    c.lightsReal as '#Focos Reales',
		    c.meterCharge as '\$\$\$Tarifa por metro',
		    c.metersCharge as '\$\$\$Cargo por metros',
		    c.lightCharge as '\$\$\$Tarifa por foco',
		    c.lightsCharge as '\$\$\$Cargo por focos',
		    c.totalCharge as '\$\$\$Cargo total',
		    c.isChecked as '!Verificado',
		    c.score as 'Puntuaci&oacute;n .tc',
		    c.notes as 'Notas',
		    c.created_at as 'F. Creacion .tc'
		from charges c
		join zones z
		on c.idZone = z.id
		and c.idMerchant = " . $merchant->id . "
		order by c.year;";

		$charges = Own::queryToArray($queryCharges);

		$data = array(
			'merchant' => $merchant,
			'charges' => $charges,
			'message' => $message,
			'class' => $class
		);
		
		return view('merchantCharges', $data);

	}

	/**
	*
	* Funcion para eliminar un comerciante
	* @param Request
	* @return view
	* 
	*/

	public function deleteMerchant(Request $request){

		$inputs = $request->toArray();		//Obtenemos la peticion

		$message = '';
		$class = '';

		if($inputs['id'] != ''){			//Verificamos si el id tiene algun valor

			$merchant = Merchant::find($inputs['id']);	//Buscamos y eliminamos el comerciante
			
			if(isset($merchant)){

				$merchant->delete();

				Charge::where('idMerchant', $inputs['id'])->delete();	//Asi mismo eliminamos los cargos

				$message = 'Comerciante eliminado con exito!';			//Ajustamos los parametros
				$class = 'bg-info';
				
			}

		}
		
		return $this->displayMerchants($message, $class);			//Retornamos la vista

	}

	/**
	*
	* Funcion para mostrar la plantilla de agregado del comerciante sin recibo
	* @return View
	*
	*/

	public function displayAddReceiptMerchantBlade(){

		$localValues = array(

			['value' => '1', 'label' => 'Si'],
			['value' => '0', 'label' => 'No'],

		);

		$tradingsValues = $this->getTradingsArray();

		$zonesValues = $this->getZonesArray();

		$incomeValues = array(
			['value' => 'Variable', 'label' => 'Variable'],
			['value' => 'Fijo', 'label' => 'Fijo'],
		);

		$queryLightCost = "select value
			from variables
			where name = 'perLightCost';";

		$lightCharge = Own::queryToData($queryLightCost);

		$queryCurrentIncrease = "select value
			from variables
			where name = 'currentIncrease';";

		$currentIncrease = Own::queryToData($queryCurrentIncrease);

		$data = array(

			'localValues' => $localValues,
			'tradingsValues' => $tradingsValues,
			'zonesValues' => $zonesValues,
			'incomeValues' => $incomeValues,
			'lightCharge' => $lightCharge,
			'currentIncrease' => $currentIncrease,
			'message' => '',
			'class' => ''

		);
		

		return view('addReceiptMerchant', $data);

	}

	/**
	*
	* Funcion para mostrar la plantilla de agregado del nuevo comerciante
	* @return View
	*
	*/

	public function displayAddNewMerchantBlade(){

		$queryTradings = "";

		$localValues = array(

			['value' => '1', 'label' => 'Si'],
			['value' => '0', 'label' => 'No'],

		);

		$incomeValues = array(
			['value' => 'Variable', 'label' => 'Variable'],
			['value' => 'Fijo', 'label' => 'Fijo'],
		);

		$queryLightCost = "select value
			from variables
			where name = 'perLightCost';";

		$lightCharge = Own::queryToData($queryLightCost);

		$queryCurrentIncrease = "select value
			from variables
			where name = 'currentIncrease';";

		$currentIncrease = Own::queryToData($queryCurrentIncrease);

		$data = array(
			'message' => '',
			'class' => '',
			'localValues' => $localValues,
			'tradingsValues' => $this->getTradingsArray(),
			'zonesValues' => $this->getZonesArray(),
			'incomeValues' => $incomeValues,
			'lightCharge' => $lightCharge,
			'currentIncrease' => $currentIncrease

		);
		

		return view('addNewMerchant', $data);

	}

	/**
	*
	* Funcion para agregar un nuevo comerciante
	* @param Request
	* @return View
	*
	*/

	public function addNewMerchant(Request $request){

		$inputs = $request->toArray();

		$merchantExists = Own::queryToSingleArray("select * from merchants where phone = " . $inputs['phone'] . " and deleted_at is null");
		
		if(isset($merchantExists['phone'])){

			$data = array(

				'inputs' => $inputs,
				'message' => 'Comerciante ya existente, favor de intentar con otro numero de telefono',
				'class' => 'bg-danger',
				'inputs' => $inputs,
				'localValues' => $this->getLocalValues(),
				'tradingsValues' => $this->getTradingsArray(),
				'zonesValues' => $this->getZonesArray(),
				'incomeValues' => $this->getIncomeValues(),
				'lightCharge' => $this->getLightCharge(),
				'currentIncrease' => $this->getCurrentIncrease(),

			);

			return view('addNewMerchant', $data);

		}

		$merchant = $this->firstOrNewMerchant($inputs);

		$chargeAttributes = array(
			'idMerchant' => $merchant->id,
			'idZone' => $inputs['idZone'],
			'year' => date('Y'),
			'frontLength' => $inputs['frontLength'],
			'wideLength' => $inputs['wideLength'],
			'lightsOral' => $inputs['lightsOral'],
			'lightsReal' => $inputs['lightsOral'],
			'meterCharge' => ($inputs['meterCharge']),
			'metersCharge' => ($inputs['meterCharge']) * $inputs['wideLength'],
			'lightCharge' => $inputs['lightCharge'],
			'lightsCharge' => ($inputs['lightCharge'] * $inputs['lightsOral']),
			'totalCharge' =>  (($inputs['meterCharge']) * $inputs['wideLength']) + ($inputs['lightCharge'] * $inputs['lightsOral']),
			'isChecked' => '0',
			'score' => '5',
			'notes' => $inputs['notes']
		);

		$charge = $this->firstOrNewCharge($chargeAttributes);

		$message = 'Comerciante agregado con exito';
		$class = 'bg-info';

		return $this->displayMerchants($message, $class);

	}

	/**
	*
	* Funcion para obtener los giros
	* @return Array
	*
	*/

	public function getTradingsArray(){

		$queryTradings = "select r.idTrading as 'value', t.description as 'label'
			from rates r
			inner join tradings t
			on r.idTrading = t.id
			and r.deleted_at is null
			group by r.idTrading, t.description;";

		$tradingsValues = Own::queryToArray($queryTradings);

		return $tradingsValues;

	}

	/**
	*
	* Funcion para obtener las zonas
	* @return Array
	*
	*/

	public function getZonesArray(){

		$queryZones = "select r.idZone as 'value', z.description as 'label'
			from rates r
			inner join zones z
			on r.idZone= z.id
			and r.deleted_at is null
			group by r.idZone, z.description;";


		$zonesValues = Own::queryToArray($queryZones);

		return $zonesValues;

	}

	/**
	*
	* Funcion para obtener las zonas
	* @return Array
	*
	*/

	public function displayUpdateBlade(Request $request){

		$inputs = $request->toArray();

		if(isset($inputs['id'])){

			$merchant = Merchant::find($inputs['id']);
			
			if(isset($merchant)){
				
				$localValues = array(

					['value' => '1', 'label' => 'Si'],
					['value' => '0', 'label' => 'No'],

				);

				$incomeValues = array(
					['value' => 'Variable', 'label' => 'Variable'],
					['value' => 'Fijo', 'label' => 'Fijo'],
				);

				$data = array(
					'merchant' => $merchant,
					'tradingsValues' => $this->getTradingsArray(),
					'localValues' => $localValues,
					'incomeValues' => $incomeValues
				);

				return view('editMerchant', $data);
					
			}

		}

		return $this->displayMerchants('', '');

	}

	/**
	*
	* Funcion para obtener las zonas
	* @return Array
	*
	*/

	public function updateMerchant(Request $request){

		$inputs = $request->toArray();

		$merchant = $this->firstOrNewMerchant($inputs);

		$message = '';
		$class = '';

		if(isset($merchant)){

			$message = 'Comerciante actualizado con exito!';
			$class = 'bg-info';

		}

		return $this->displayMerchants($message, $class);

	}

	/**
	*
	* Funcion para mostrar la plantilla para agregar el cargo cuando existe recibo
	* @return Array
	*
	*/

	public function displayReceiptChargeBlade(Request $request){

		$inputs = $request->toArray();

		if(
			isset($inputs['idMerchant']) && 
			isset($inputs['idTrading']) && 
			isset($inputs['isLocal'])
		){

			$merchant = Merchant::find($inputs['idMerchant']);

			$queryLightCost = "select value
				from variables
				where name = 'perLightCost';";

			$lightCharge = Own::queryToData($queryLightCost);

			$queryCurrentIncrease = "select value
				from variables
				where name = 'currentIncrease';";

			$currentIncrease = Own::queryToData($queryCurrentIncrease);

			$data = array(
				'merchant' => $merchant,
				'tradingsValues' => $this->getTradingsArray(),
				'zonesValues' => $this->getZonesArray(),
				'lightCharge' => $lightCharge,
				'currentIncrease' => $currentIncrease,
				'message' => '',
				'class' => 'bg-danger'
			);

			return view('addReceiptCharge', $data);

		} else {

			return $this->displayMerchants('', '');

		}


	}

	/**
	*
	* Funcion para mostrar la plantilla para agregar el cargo cuando no existe recibo
	* @return Array
	*
	*/

	public function displayNewChargeBlade(Request $request){

		$inputs = $request->toArray();

		if(
			isset($inputs['idMerchant']) && 
			isset($inputs['idTrading']) && 
			isset($inputs['isLocal'])
		){

			$merchant = Merchant::find($inputs['idMerchant']);

			$queryLightCost = "select value
				from variables
				where name = 'perLightCost';";

			$lightCharge = Own::queryToData($queryLightCost);

			$queryCurrentIncrease = "select value
				from variables
				where name = 'currentIncrease';";

			$currentIncrease = Own::queryToData($queryCurrentIncrease);

			$data = array(
				'merchant' => $merchant,
				'tradingDescription' => $this->getTradingsArray(),
				'tradingsValues' => $this->getTradingsArray(),
				'zonesValues' => $this->getZonesArray(),
				'lightCharge' => $lightCharge,
				'currentIncrease' => $currentIncrease
			);

			return view('addNewCharge', $data);

		} else {

			return $this->displayMerchants('', '');

		}


	}

	/**
	*
	* Funcion para agregar los datos del cargo cuando no hay recibo
	* @return Array
	*
	*/

	public function addNewCharge(Request $request){

		$inputs = $request->toArray();

		$chargeAttributes = array(
			'idMerchant' => $inputs['idMerchant'],
			'idTrading' => $inputs['idTrading'],
			'idZone' => $inputs['idZone'],
			'year' => date('Y'),
			'frontLength' => $inputs['frontLength'],
			'wideLength' => $inputs['wideLength'],
			'lightsOral' => $inputs['lightsOral'],
			'lightsReal' => $inputs['lightsOral'],
			'meterCharge' => $inputs['meterCharge'],
			'metersCharge' => $inputs['meterCharge'] * $inputs['wideLength'],
			'lightCharge' => $inputs['lightCharge'],
			'lightsCharge' => ($inputs['lightCharge'] * $inputs['lightsOral']),
			'totalCharge' =>  ($inputs['meterCharge'] * $inputs['wideLength']) + ($inputs['lightCharge'] * $inputs['lightsOral']),
			'isChecked' => '0',
			'score' => '5',
			'notes' => $inputs['notes']
		);

		$charge = $this->addCharge($chargeAttributes);

		$request['id'] = $inputs['idMerchant'];
		$request['message'] = 'Cargo agregado con exito!';
		$request['class'] = 'bg-success';

		return $this->displayMerchantCharges($request);

	}

	/**
	*
	* Funcion para eliminar un cargo
	* @param Request
	* @return view
	* 
	*/

	public function deleteCharge(Request $request){

		$inputs = $request->toArray();		//Obtenemos la peticion

		$message = '';
		$class = '';

		$idMerchant = '';

		if($inputs['id'] != ''){			//Verificamos si el id tiene algun valor

			$charge = Charge::find($inputs['id']);	//Buscamos y eliminamos el comerciante
			
			if(isset($charge)){

				$idMerchant = $charge->idMerchant;

				$charge->delete();			//Se elimina el cargo

				$message = 'Cargo eliminado con exito!';			//Ajustamos los parametros
				$class = 'bg-info';
				
			}

		}
		
		$request['id'] = $idMerchant;
		$request['message'] = 'Cargo eliminado con exito!';
		$request['class'] = 'bg-success';

		return $this->displayMerchantCharges($request);			//Retornamos la vista

	}

	/**
	*
	* Funcion para mostrar el resumen
	* @return View
	*
	*/

	public function displayIncomeResume(){

		$queryTradingResume = "
			
			SELECT '<b>Total</b>', sum(totalCharge) as '\$\$\$Monto'
			FROM charges
			WHERE year = '2016'

			UNION ALL

			SELECT t.description as 'Giro comercial', sum(c.totalCharge) as '\$\$\$Monto'
			from charges c
			join merchants m
			join tradings t
			on c.idMerchant = m.id
			and m.idTrading = t.id
			and c.year = '2016'
			group by t.description
			order by \$\$\$Monto";

		$tradingResume = Own::queryToArray($queryTradingResume);

		$queryLocalResume = "
			
			SELECT '<b>Total</b>', sum(totalCharge) as '\$\$\$Monto'
			FROM charges
			WHERE year = '2016'

			UNION ALL

			SELECT 
				case m.isLocal when m.isLocal = 2 THEN 'Externo' ELSE 'Local' end, 
				sum(c.totalCharge) as '\$\$\$Monto'
			from charges c
			join merchants m
			on c.idMerchant = m.id
			and c.year = '2016'
			group by m.isLocal
			order by \$\$\$Monto";

		$localResume = Own::queryToArray($queryLocalResume);

		$queryZoneResume = "

			SELECT '<b>Total</b>', sum(totalCharge) as '\$\$\$Monto'
			FROM charges
			WHERE year = '2016'

			UNION ALL

			select z.description as 'Giro comercial', sum(c.totalCharge) as '\$\$\$Monto'
			from charges c
			join zones z
			on c.idZone = z.id
			and c.year = '2016'
			group by z.description
			order by \$\$\$Monto";

		$zonesResume = Own::queryToArray($queryZoneResume);

		$queryDayResume = "
			SELECT concat(day(created_at), '-', month(created_at))  as Dia, sum(totalCharge) as '\$\$\$Monto'
			FROM charges
			where year = '2016'
			group by Dia
			order by created_at;";

        $dayResume = Own::queryToArray($queryDayResume);

		$data = array(

			'tradingResume' => $tradingResume,
			'zonesResume' => $zonesResume,
			'localResume' => $localResume,
			'dayResume' => $dayResume

		);

		return view('incomeResume', $data);

	}

	/**
	*
	* Funcion para regresar los valores booleanos
	*
	*/

	public function getLocalValues(){

		$localValues = array(

			['value' => '1', 'label' => 'Si'],
			['value' => '0', 'label' => 'No'],

		);

		return $localValues;

	}

	/**
	*
	* Funcion para regresar los valores del tipo de entrada
	* @return Array
	*
	*/

	public function getIncomeValues(){

		$incomeValues = array(
			['value' => 'Variable', 'label' => 'Variable'],
			['value' => 'Fijo', 'label' => 'Fijo'],
		);

		return $incomeValues;

	}

	/**
	*
	* Funcion para regresar los valores del tipo de entrada
	* @return Array
	*
	*/

	public function getLightCharge(){

		$queryLightCost = "select value
			from variables
			where name = 'perLightCost';";

		$lightCharge = Own::queryToData($queryLightCost);

		return $lightCharge;

	}

	/**
	*
	* Funcion para regresar el incremento de tarifa
	* @return Array
	*
	*/

	public function getCurrentIncrease(){

		$queryCurrentIncrease = "select value
			from variables
			where name = 'currentIncrease';";

		$currentIncrease = Own::queryToData($queryCurrentIncrease);

		return $currentIncrease;

	}

	/**
	*
	* Funcion para agregar un cargo
	* @param Array attributes
	* @return View
	*
	*/

	public function addCharge($attributes){

		$charge = new Charge;

		$charge->idMerchant = $attributes['idMerchant'];
		$charge->idTrading = $attributes['idTrading'];
		$charge->idZone = $attributes['idZone'];
		$charge->year = $attributes['year'];

		$charge->frontLength = $attributes['frontLength'];
		$charge->wideLength = $attributes['wideLength'];

		$charge->lightsOral = $attributes['lightsOral'];
		$charge->lightsReal = $attributes['lightsReal'];

		$charge->meterCharge = $attributes['meterCharge'];
		$charge->metersCharge = $attributes['metersCharge'];

		$charge->lightCharge = $attributes['lightCharge'];
		$charge->lightsCharge = $attributes['lightsCharge'];

		$charge->totalCharge = $attributes['totalCharge'];

		$charge->isChecked = $attributes['isChecked'];

		$charge->score = $attributes['score'];
		$charge->notes = $attributes['notes'];

		$charge->randomKey = str_replace(['/', '\\', '.'], "-", Hash::make(str_random(20)));

		$charge->save();

		$this->createQrCode($charge);

		return $charge;

	}


	




}
