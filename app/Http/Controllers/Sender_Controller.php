<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sender;
use App\Agent_sender;
use DB;
class Sender_Controller extends Controller
{
    //
	public function sender_list(){
		$agentSenders = Agent_sender::with('sender')->orderBy('created_at','desc')->get();
		return $agentSenders;
	}

	public function search(Request $request){
		$agent = $request->input('agent');
		$keyword = $request->input('keyword');
		$senders = Sender::with('beneficiary')->from('senders')
		->join('agent_senders','agent_senders.sender_id','=','senders.id')
		->join('agents','agents.id','=','agent_senders.agent_id')
		->where(function ($query) use ($agent){
			if ($agent>0){
				$query->where('agent_senders.agent_id','=',$agent);
			}
		})
		->where(function ($query) use ($keyword){
			$query->where('senders.fname','LIKE',"%$keyword%");
			$query->orWhere('senders.lname','LIKE',"%$keyword%");
			$query->orWhere(DB::raw('CONCAT_WS(" ",senders.fname,senders.lname)'),'like', "%$keyword%");
			$query->orWhere(DB::raw('CONCAT_WS(" ",senders.lname,senders.fname)'),'like', "%$keyword%");        

                            //$query->orWhere('senders.lname','like', "$keyword%");
                            //$query->orWhere('senders.mname','like', "$keyword%");
		})
		->select('senders.*','agents.agent_code','agents.business_name')
		->take(10)
		->get();
		return $senders;
        //$test = $request->all();
        //return response()->success(compact('agent','test'));
	}
}
