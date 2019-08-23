<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeCenter extends Model
{
    protected $table = "mode_centers";

    public function service_center(){
		return $this->belongsto('App\Service_Center');
	}

	 public function service_mode(){
		return $this->belongsto('App\ServiceMode');
	}

}
