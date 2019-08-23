<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange_rate extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\User');
    }
}
