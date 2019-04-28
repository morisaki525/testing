<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Laravel\Passport\Client;
use  Illuminate\Support\Facades\Route;



class RegisterController extends Controller
{
    //
    use IssueTokenTrait;


    private $client;

    public function __construct()
    {
        $this->client = Client::find(2);
    }


    public function register(Request $request){

        //dd($request->all());

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        if($this->client != null){
            $user = User::create([
                'user_name' => request('name'),
                'email' => request('email'),
                'password' => bcrypt('password'),
                'user_NIC' => request('user_NIC'),
                'user_phone' => request('user_phone'),
                'user_addr' => request('user_addr'),
                'met_id' => request('met_id')

            ]);
        }

       
        /*
        $params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => request('email'),
            'password' => request('password'),
            'scope' => '*',
        ];

        $request->request->add($params);

        $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);
        */

        return $this->issueToken($request, 'password');


    }

}
