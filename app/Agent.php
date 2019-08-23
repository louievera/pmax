<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{

	protected $table = "agents";

     public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }
     // results in a "problem", se examples below
    public function transaction_today() {
        return $this->transaction()->where('created_at','like', date('Y-m-d').'%');
    }

    public function agent_payment()
	{
		return $this->hasMany('App\Agent_Payment');
    }
    
    public function branche_list(){
		return Agent::hasMany('App\agent_sender');
	}

	

}
