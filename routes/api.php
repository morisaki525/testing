<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    //return $request->user();
    dd('salut');
});
*/

Route::middleware('auth:api')->group(function(){
    Route::post('logout', 'Api\Auth\LoginController@logout');

    Route::get('posts', 'Api\RecordController@index');

    Route::get('history', 'Api\RecordController@history');

    Route::post('paid', 'Api\RecordController@paid');

    Route::get('profile', 'Api\MeterController@profile');

    Route::get('balance', 'Api\MeterController@balance');

    Route::post('upbill', 'Api\MeterController@upbill');

});
