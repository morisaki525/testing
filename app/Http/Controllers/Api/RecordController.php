<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class RecordController extends Controller
{
    //
    public function index()
    {

        $record = Auth::user()->record()->get();
        /*
        $record = Auth::user()->join('records', 'records.user_id', '=', 'users.id')->join('users', 'users.bal_id', '=', 'balances.bal_id')->select(
            'records.rec_id',
            'records.met_id',
            'records.user_id',
            'records.rec_unit',
            'records.rec_cash',
            'records.rec_dute_date',
            'records.rec_pay_date',
            'records.rec_create_date',
            'records.rec_paid',
            'balances.bal_amount',
            'records..created_at',
            'records..updated_at'
        )->get();
        */
        //dd($posts);
/*
        "rec_id" : 1 ,
            "met_id" : "OKK1" ,
            "user_id" : 1 ,
            "rec_unit" : 150 ,
            "rec_cash" : 7500 ,
            "rec_dute_date" : "2018-09-08" ,
            "rec_pay_date" : "0000-00-00" ,
            "rec_create_date" : "2018-08-08" ,
            "rec_paid" : 1 ,
            "created_at" : null,
            "updated_at" : "2018-08-31 05:33:34"
*/
        return response()->json(['data' => $record], 200, [], JSON_NUMERIC_CHECK);

    }

    public function history()
    {
        $history = Auth::user()->record()->where('rec_paid', '1')->orderBy('rec_create_date', 'desc')->get();
        //dd($posts);
        //         ->orderBy('rec_create_date', 'desc')

        return response()->json(['data' => $history], 200, [], JSON_NUMERIC_CHECK);

    }

    public function paid(Request $request)
    {

        //$billamount = DB::table('billcodes')->select('billcodes.bill_amount')->where('billcodes.bill_code', '=', $request->bill_code)->get();

        $currentamount = Auth::user()->join('balances', 'users.bal_id', '=', 'balances.bal_id')->select('balances.bal_amount')->get();

        $billamount = Auth::user()->record()->select('records.rec_cash')->where('rec_id', $request->rec_id)->get();

        $current = $currentamount[0]->bal_amount;
        $bill = $billamount[0]->rec_cash;

        if ( ($current != null) || ($current >= $bill) ) {
            
            $subamount = $current - $bill;


            $upbill = Auth::user()->balance()->update(['balances.bal_amount' => $subamount]);
            $upbill = 'success bill = ' . $subamount;

            $paid = Auth::user()->record()->where('rec_id', $request->rec_id)->update(['rec_paid' => 1]);

        } else {
            $upbill = 'Not Enugh Bill !';
        }


        
        


        
        //dd($posts);
        //         ->orderBy('rec_create_date', 'desc')
/*
        where('active', 1)
            ->where('destination', 'San Diego')
            ->update(['delayed' => 1]);
*/
        return response()->json(['data' => $upbill], 200, [], JSON_NUMERIC_CHECK);

    }

}
