<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service_Mode;
class Servicemode_Controller extends Controller
{
    //
    public function serviceModeList(){
        $list = Service_Mode::get();

        return $list;
    }
}
