<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Agent_Payment;
use Auth;
use Illuminate\Http\Request;
use DB;
class AgentPayment_Controller extends Controller
{
	public function agent_payment($id){

		return $agent_payment = Agent_Payment::where('agent_id','=',$id)->get();
	}

	public function store(Request $request){
		$agent_payment  = new Agent_Payment;
		$agent_payment->user_id = Auth::id();
		$agent_payment->agent_id = $request->input('id');
		$agent_payment->payment_amount = $request->input('payment_amount');
		$agent_payment->bank = $request->input('bank');
		$agent_payment->bank_branch = $request->input('bank_branch');
		$agent_payment->date_posted = $request->input('date_posted');
		$agent_payment->save();


		$agent  = Agent::with('agent_payment')->get();


		for($i = 0 ; $i < count($agent); $i++){
			$agent[$i]->total_branch_payment =  number_format($agent[$i]->agent_payment->sum('payment_amount'),2);
			$agent[$i]->total_payable = number_format(DB::table('transactions')->where('agent_id','=',$agent[$i]->id)->sum('total_payment'),2);
		}

		return $agent;

		
	}
}
