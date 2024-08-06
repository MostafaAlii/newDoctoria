<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class FawryApiService
{
    protected $client;
    protected $merchantCode;
    protected $secureKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->merchantCode = env('FAWRY_MERCHANT_CODE');
        $this->secureKey = env('FAWRY_SECURE_KEY');
    }

    public function initiatePayment($data)
    {
        $endpoint = 'https://www.atfawry.com/ECommerceWeb/Fawry/payments/charge';
        
        $data['merchantCode'] = $this->merchantCode;
        $data['signature'] = $this->generateSignature($data);

        // Log request data for debugging
        \Log::info('Fawry Request Data:', $data);

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            \Log::error('Fawry Error:', [
                'message' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No response'
            ]);

            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    private function generateSignature($data)
    {
        $stringToSign = $this->merchantCode . $data['merchantRefNum'] . $data['customerProfileId'] . $data['paymentMethod'] . $data['amount'] . $this->secureKey;
        return hash('sha256', $stringToSign);
    }
}
