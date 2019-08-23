<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	public function user(){
		return $this->belongsTo('App\User');
	}
	public function sender(){
		return $this->belongsTo('App\Sender');
	}
	public function beneficiary(){
		return $this->belongsTo('App\Beneficiary');
	}
	public function beneficiary_service_center(){
		return $this->belongsto('App\BeneficiaryServiceCenter');
	}
	public function completed_by_user(){
		return $this->belongsTo('App\User','completed_by');
	}
	public function approved_by_user(){
		return $this->belongsTo('App\User','approved_by');
	}
	

	
	

	
}
