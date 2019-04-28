<?php

namespace App;

use App\Meter;
use App\Record;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

//add
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'email', 'password', 'user_NIC', 'user_phone', 'user_addr', 'met_id',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //add
    public function record(){
        return $this->hasMany(Record::class);
    }

    

    public function meter()
    {
        return $this->hasOne(Meter::class);
    }

    public function balance()
    {
        return $this->hasOne(Balances::class);
    }

    public function billcode()
    {
        return $this->hasMany(Billcodes::class);
    }


}
