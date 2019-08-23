<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Agent;

class Sender extends Model
{
	protected $hidden = ['created_at','updated_at'];
	protected $table = "senders";

	public function agent_sender_list(){
		return $this->belongsTo('App\agent_sender')->orderBy('id','desc');
	}

	public function beneficiary(){
		return $this->BelongstoMany('App\Beneficiary','sender_beneficiaries');
	}
}
