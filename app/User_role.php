<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_role extends Model
{
    //
    public function agent(){
        return user_role::belongsTo('App\Agent');
    }

    public function user(){
        return user_role::belongsTo('App\User');
    }
    public function role(){
        return user_role::belongsTo('App\Role');
    }
}
