<?php

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

Route::get('/', 'LoginController@showLogin');

Route::post('login', 'LoginController@postLogin');

Route::get('addUser', function(){ return view('addUser'); } );

Route::post('addUser', 'UsersController@addUser');

Route::post('addZone', 'ZonesController@addZone');

Route::get('showUsers', 'UsersController@showUsers');

Route::get('zones', 'ZonesController@displayZones');

Route::get('tradings', 'TradingsController@displayTradings');

Route::post('addTrading', 'TradingsController@addTrading');

Route::get('addTrading', 'TradingsController@displayTradings');

Route::get('rates', 'RatesController@displayGetRates');

Route::post('addRate', 'RatesController@addRate');

Route::get('variables', 'VariablesController@displayGetVariables');

Route::post('addVariable', 'VariablesController@addVariable');

Route::get('merchants', 'MerchantsController@displayGetMerchants');

Route::post('addMerchant', 'MerchantsController@addMerchant');

Route::post('printReceipt', 'MerchantsController@printReceipt');