<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::get('serviceCharges', 'Maintenance_Controller@service_charge');
Route::get('exchangeRate', 'Exchangerate_Controller@current_exchangerate');
Route::get('transactionLogs', 'Transaction_Controller@transaction_logs');
Route::get('dailyTransaction', 'Transaction_Controller@daily_transaction');
Route::get('agentPayable/{agent?}', 'Transaction_Controller@find_transaction_group');
Route::get('transactionChart', 'Transaction_Controller@transaction_chart');
Route::get('transactionList', 'Transaction_Controller@transaction_list');

// Maintenance
Route::get('senderList','Sender_Controller@sender_list');
Route::get('usersList','Users_Controller@users_list');
Route::get('serviceModes','Servicemode_Controller@serviceModeList');
Route::get('serviceCenter','ServiceCenter_Controller@service_center');
Route::get('exchangeRateList', 'Exchangerate_Controller@exchange_rate_list');
Route::post('addExchangeRate', 'Exchangerate_Controller@insert_rate');
// Route::group(['middleware'=>['web']], function(){
// 	Route::get('test', function(){return Auth::user()->id;});
// Route::post('addExchangeRate', 'Exchangerate_Controller@insert_rate');

// });



Route::get('regUsers','Users_Controller@registered_users_list');


Route::get('agent', 'Agent_Controller@index');
Route::put('agent/{id}/hold', 'Agent_Controller@hold');
Route::put('agent/{id}/unhold', 'Agent_Controller@unhold');
//end hold branch


Route::get('agent/payment', 'Agent_Controller@payment');
Route::get('agent_payment/agent/{id}', 'AgentPayment_Controller@agent_payment');
Route::post('agent_payment', 'AgentPayment_Controller@store');


Route::get('transaction','Transaction_Controller@transaction');
Route::get('transaction/search','Transaction_Controller@search');



Route::get('transactionstatus','TransactionStatus_Controller@index');

Route::get('transaction/exports','Transaction_Controller@export');



//for austrac report 
Route::get('transaction/austrac/search','Transaction_Controller@austrac_search');
//for austrac counts 

Route::get('transaction/counts','Transaction_Controller@counts');


//certificate//
Route::get('sender/search','Sender_Controller@search');

//endcertificate


//bank to bank//
Route::get('transaction/bank_to_bank/search','Transaction_Controller@bank_to_bank_search');

//endbanktobank


