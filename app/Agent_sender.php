<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent_sender extends Model
{
    //
    public function sender(){
        return $this->belongsTo('App\Sender');
    }
}
