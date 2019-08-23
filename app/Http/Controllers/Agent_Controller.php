<?php

namespace App\Http\Controllers;

use App\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class Agent_Controller extends Controller
{
	public function index(){
		
		return $agent  = Agent::all();

	}
	public function hold(Request $request){

		$agent = Agent::find($request->input('id'));
		$agent->agent_status = 1 ;
		$agent->remarks = $request->input('remarks');
		$agent->save();
		return $this->index();
	}
	public function unhold(Request $request){

		$agent = Agent::find($request->input('id'));
		$agent->agent_status = 0 ;
		$agent->save();
		return $this->index();
	}

	public function payment(){

		$agent  = Agent::with('agent_payment')->get();


		for($i = 0 ; $i < count($agent); $i++){
			$agent[$i]->total_branch_payment =  number_format($agent[$i]->agent_payment->sum('payment_amount'),2);
			$agent[$i]->total_payable = number_format(DB::table('transactions')->where('agent_id','=',$agent[$i]->id)->sum('total_payment'),2);
		}

		return $agent;
	}
}
