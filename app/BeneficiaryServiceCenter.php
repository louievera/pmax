<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeneficiaryServiceCenter extends Model
{
	protected $table = "beneficiary_service_centers";

	public function mode_center(){
		return $this->belongsto('App\ModeCenter');
	}
}
