<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\registered_user;
use App\User_role;
use App\Role;

class Users_Controller extends Controller
{
    //
    public function users_list(){
        // $users = registered_user::get();
        $users = User_role::with('agent','user','role')->get();
        return $users;
    }
}
