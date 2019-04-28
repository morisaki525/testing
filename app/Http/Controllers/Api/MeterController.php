<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//add
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MeterController extends Controller
{
    //
    public function index(){
        $meter = Auth::user()->meter()->get();
        //dd($posts);

        return response()->json(['data' => $meter], 200, [], JSON_NUMERIC_CHECK);

    }

    public function profile(){
        $profile = Auth::user()->join('meters', 'users.met_id', '=', 'meters.met_id')->select('users.id', 'users.user_name', 'users.email', 'users.password',
                'users.user_NIC',
                'users.user_phone',
                'users.user_addr',
                'users.met_id',
                'meters.met_name',
            'meters.met_type',
            'users.created_at',
            'users.updated_at')->get();

       // `id`, `user_name`, `email`, `password`, `user_NIC`, `user_phone`, `user_addr`, `met_id`, `remember_token`, `created_at`, `updated_at`

        //    `met_id`, `met_name`, `met_type`, `created_at`, `updated_at`, `user_id`


        return response()->json(['data' => ($profile)], 200, [], JSON_NUMERIC_CHECK);
    }

    public function balance()
    {
        $amount = Auth::user()->join('balances', 'users.bal_id', '=', 'balances.bal_id')->select(
            'users.id',
            'users.user_name',
            'users.email',
            'balances.bal_id',
            'balances.bal_amount')->get();
        //dd($posts);

        return response()->json(['data' => $amount], 200, [], JSON_NUMERIC_CHECK);

    }

    public function upbill(Request $request){

        /*
        $billamount = DB::table('billcodes')->select('billcodes.bill_amount')->where('billcodes.bill_code', '=', $request->bill_code)->get();
        
        if(  !(is_null($billamount)) || !(empty($billamount)) ){

            $currentamount = Auth::user()->join('balances', 'users.bal_id', '=', 'balances.bal_id')->select('balances.bal_amount')->get();

            $addamount = $billamount[0]->bill_amount + $currentamount[0]->bal_amount;

            $upbill = Auth::user()->balance()->update(['balances.bal_amount' => $addamount]);
            $upbill = $addamount;
        }else{
            $upbill = 0;
        }
        */

        try {

            $billamount = DB::table('billcodes')->select('billcodes.bill_amount')->where('billcodes.bill_code', '=', $request->bill_code)->get();
            //dd($billamount);

            if ( $billamount->isNotEmpty()  ) {

                $currentamount = Auth::user()->join('balances', 'users.bal_id', '=', 'balances.bal_id')->select('balances.bal_amount')->get();

                $addamount = $billamount[0]->bill_amount + $currentamount[0]->bal_amount;

                $upbill = Auth::user()->balance()->update(['balances.bal_amount' => $addamount]);
                $upbill = $addamount;
            } else {
                $upbill = -1;
            }

        } catch (Exception $e) {
            $upbill = -1;
        }

        //dd($billamount,$addamount);
    
        //DB::table('users')->get();

        //$upbill = Auth::user()->where('', '>', 100)->update(['status' => 2]);

        //->join('balances', 'users.bal_id', '=', 'balances.bal_id')
        //dd($posts);

       return response()->json(['data' => $upbill], 200, [], JSON_NUMERIC_CHECK);

    }

}
