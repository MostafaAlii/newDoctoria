<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FawryApiService;

class FawryApiController extends Controller
{
    protected $fawryService;

    public function __construct(FawryApiService $fawryService)
    {
        $this->fawryService = $fawryService;
    }

    public function initiatePayment(Request $request)
    {
        $data = [
            'merchantCode' => env('FAWRY_MERCHANT_CODE'),
            'merchantRefNum' => $request->input('merchantRefNum'),
            'customerProfileId' => $request->input('customerProfileId'),
            'paymentMethod' => 'CARD',
            'amount' => $request->input('amount'),
            'currencyCode' => 'EGP',
            'language' => 'en-gb',
            'customerMobile' => $request->input('customerMobile'),
            'customerEmail' => $request->input('customerEmail'),
            'chargeItems' => [
                [
                    'itemId' => '1',    
                    'price' => $request->input('amount'),
                    'quantity' => 1,
                ],
            ],
            'returnUrl'=> 'https://developer.fawrystaging.com',
            'cardNumber' => $request->input('cardNumber'),
            'expiryYear' => $request->input('expiryYear'),
            'expiryMonth' => $request->input('expiryMonth'),
            'cvv' => $request->input('cvv')
        ];

        $response = $this->fawryService->initiatePayment($data);
        dd($response);
        return response()->json($response);
    }

    public function handleCallback(Request $request)
    {
        return response()->json(['status' => 'success']);
    }
}
