<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api_Trait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Paymob;
use Illuminate\Support\Facades\Auth;
use Response;

class PaymobController extends Controller
{
    //
    use Api_Trait;
    public function index(Request $request){
        //if(Auth::guard('patient')->check()) {
            $paymob = new Paymob;
            $data = ['email' => 'test@test.com', 'first_name'=>'test', 'last_name'=> 'test', 'phone_number'=>'01121006501'];
            $amount = 100;
            //mobile  =>  env('IFRAME_ONLINE_CARD_ID')
            //card    =>  env('IFRAME_WALLET_ID')
            $link = $paymob->pay($data, $amount ,env('IFRAME_ONLINE_CARD_ID'));
            return Response::json($link, 200);
        //}
        //return 'unsuccess';
    }

    public function callback(Request $request) {
        $paymob = new Paymob;
        $callback = $paymob->callback($request);
        if($callback['success'] == true){
            //
        }
    }

    // public function index(Request $request){
    //     $paymob = new Paymob;
    //     $data = [
    //         'email' => $request->email,
    //         'first_name' => $request->first_name, 
    //         'last_name' => $request->last_name, 
    //         'phone_number' => $request->phone_number
    //     ];
    //     $amount = $request->amount;
    //     return $paymob->pay($data, $amount);
    // }
}
