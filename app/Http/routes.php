<?php

use Illuminate\Http\Request;

use App\Rate;

use App\Own\Own;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Registramos un grupo de rutas
Route::group(['middleware' => 'auth'], function(){

	Route::get('/', function(){

		return view('home');

	});

	Route::get('users', 'UsersController@displayGetUsers');

	/**
	*
	* Users routes
	*
	*/
	Route::post('addUser', 'UsersController@addUser');

	Route::get('updateUser', 'UsersController@updateUser');

	Route::post('updateUserData', 'UsersController@updateUserData');

	Route::get('deleteUser', 'UsersController@deleteUser');

	Route::get('usersPrivileges', 'UsersController@displayGetUsersToEdit');


	/**
	*
	* Zones routes
	*
	*/

	Route::get('zones', 'ZonesController@displayGetZones');
	
	Route::post('addZone', 'ZonesController@addZone');

	Route::get('updateZone', 'ZonesController@displayUpdateBlade');

	Route::post('updateZone', 'ZonesController@updateZone');

	Route::get('deleteZone', 'ZonesController@deleteZone');

	/**
	*
	* Tradings routes
	*
	*/

	Route::get('tradings', 'TradingsController@displayGetTradings');

	Route::post('addTrading', 'TradingsController@addTrading');

	Route::get('addTrading', 'TradingsController@displayTradings');

	Route::get('deleteTrading', 'TradingsController@deleteTrading');

	
	/**
	*
	* Rates routes
	*
	*/

	Route::get('rates', 'RatesController@displayGetRates');

	Route::post('addRate', 'RatesController@addRate');

	Route::get('updateRate', 'RatesController@displayUpdateBlade');

	Route::post('updateRate', 'RatesController@updateRate');

	Route::get('deleteRate', 'RatesController@deleteRate');

	Route::post('getAjaxRate', function(Request $request){

		$inputs = $request->toArray();
		
		$rate = Rate::where( ['isLocal' => $inputs['isLocal'], 'idTrading' => $inputs['idTrading'], 'idZone' =>$inputs['idZone'] ] )->get();
		
		if(isset($rate)){

			$data = array(
				'rate' => $rate
			);

			return Response::json($data);
			
		}

	});

	/**
	*
	* Merchants routes
	*
	*/

	Route::get('merchants', 'MerchantsController@displayGetMerchants');

	Route::post('addMerchant', 'MerchantsController@addMerchant');

	Route::get('printMerchantCharge', 'MerchantsController@printMerchantCharge');

	Route::get('addMerchant', 'MerchantsController@displayAddOptions');

	Route::get('addReceiptMerchant', 'MerchantsController@displayAddReceiptMerchantBlade');

	Route::get('addNewMerchant', 'MerchantsController@displayAddNewMerchantBlade');

	Route::post('addNewMerchant', 'MerchantsController@addNewMerchant');

	Route::post('addMerchantWithReceipt', 'MerchantsController@addMerchantWithReceipt');

	Route::get('displayMerchantCharges', 'MerchantsController@displayMerchantCharges');

	Route::get('deleteMerchant', 'MerchantsController@deleteMerchant');

	Route::get('updateMerchant', 'MerchantsController@displayUpdateBlade');

	Route::post('updateMerchant', 'MerchantsController@updateMerchant');

	Route::get('quickCheck', 'ChargesController@quickCheck');

	Route::post('evaluateCharge', 'ChargesController@evaluateCharge');

	/**
	*
	* Charges routes
	*
	*/

	Route::get('addReceiptCharge', 'MerchantsController@displayReceiptChargeBlade');

	Route::post('addReceiptCharge', 'MerchantsController@addReceiptCharge');

	Route::get('addNewCharge', 'MerchantsController@displayNewChargeBlade');

	Route::post('addNewCharge', 'MerchantsController@addNewCharge');

	Route::get('deleteCharge', 'MerchantsController@deleteCharge');

	Route::get('mapOutCharge', 'ChargesController@displayMapOutBlade');

	Route::post('mapOutCharge', 'ChargesController@mapOutCharge');

	Route::post('mapOutChargeByQr', 'ChargesController@mapOutChargeByQr');

	Route::post('displayChargeToMap', 'ChargesController@displayChargeToMap');

	Route::get('removeMap', 'ChargesController@removeMap');

	Route::get('removeMapByQr', 'ChargesController@removeMapByQr');

	/**
	*
	* Variables routes
	* 
	*/

	Route::post('addVariable', 'VariablesController@addVariable');

	Route::get('variables', 'VariablesController@displayGetVariables');
	
	/**
	* Menus routes
	*
	*/
	
	Route::get('menus', 'MenusController@displayGetMenus');

	Route::post('addMenu', 'MenusController@addMenu');

	Route::get('deleteMenu', 'MenusController@deleteMenu');

	Route::get('showUserMenu', 'UsersController@showUserMenu');

	/**
	*
	* Search routes
	*/

	Route::get('searchByCharge', 'ChargesController@displaySearchByCharge');

	Route::post('searchByCharge', 'ChargesController@searchByCharge');

});

Route::get('login', 'Auth\AuthController@displayLogin');

Route::get('logout', 'Auth\AuthController@logout');

Route::post('checkLogin', 'Auth\AuthController@checkLogin');

Route::get('incomeResume', 'MerchantsController@displayIncomeResume');

Route::post('getIncomeSeries', function(){
		
	$incomeSeries = Own::getIncomeSeries();
		
	return Response::json($incomeSeries);
			
});