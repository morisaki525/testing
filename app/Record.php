<?php

namespace App;

use App\User;
use App\Meter;


use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    public function user()
    {
        return $this->belongTo(User::class);
    }
}
