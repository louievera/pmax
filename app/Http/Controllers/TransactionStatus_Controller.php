<?php

namespace App\Http\Controllers;

use App\TransactionStatus;
use Illuminate\Http\Request;

class TransactionStatus_Controller extends Controller
{
    public function index(){
    	return TransactionStatus::all();
    }
}
