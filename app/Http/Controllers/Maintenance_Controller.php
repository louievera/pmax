<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Maintenance_Controller extends Controller
{
    //

    public function service_charge(){

        $charges=DB::table('service_modes')
                        ->select('mode_desc as name','service_charge')
                        ->where('service_charge','>',0)
                        ->get();
        
        return json_encode($charges);

    }

    
}
