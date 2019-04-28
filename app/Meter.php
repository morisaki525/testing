<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    //
    public function user(){
        return $this->belongTo(User::class);
    }

}
