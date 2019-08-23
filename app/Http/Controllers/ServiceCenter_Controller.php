<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service_Center;

class ServiceCenter_Controller extends Controller
{
    //
    public function service_center(){
        $list = Service_Center::get();

        return $list;
    }
}
