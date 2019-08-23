<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exchange_rate;
use Auth;

class Exchangerate_Controller extends Controller
{
    public $timestamps = true;
    //
    public function current_exchangerate(){
        $rate = Exchange_rate::orderBy('created_at','desc')->first();
        return $rate;
    }

    public function exchange_rate_list(){
        $list = Exchange_rate::with('user')->orderBy('created_at','DESC')->get();
        return $list;
    }

    public function insert_rate(Request $request){
        // $userid = Auth::user()->id;
        $userid = auth('api')->user()->id;
        $newRate = $request->input('rate');
        Exchange_rate::insert([ 'rate'          => $newRate,
                                'user_id'       => $userid,
                                'created_at'    => date('Y-m-d H:i:s'), 
                                'updated_at'    => date('Y-m-d H:i:s')
                            ]);
        // dd($request);
    }
}
