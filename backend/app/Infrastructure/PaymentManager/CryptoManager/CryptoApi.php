<?php

namespace App\Infrastructure\PaymentManager\CryptoManager;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use function App\Infrastructure\CryptoManager\http_req;

class CryptoApi
{

    private string $api_key;
    private string $secret_key;
    private string $base_endpoint;

    public function __construct()
    {
        $this->api_key = config('app.BYBIT_API_KEY');
        $this->secret_key = config('app.BYBIT_API_SECRET_KEY');
        $this->base_endpoint = config('app.BYBIT_API_BASE_ENDPOINT');
    }

    # GET /v5/asset/deposit/query-address?coin=USDT&chainType=ETH
    public function getMasterDepositAddress(string $coin = 'USDT', string $chain = 'TRX'): PromiseInterface|Response
    {
        $params = 'coin=' .$coin. '&chainType=' .$chain;
        $endpoint = $this->base_endpoint . '/v5/asset/deposit/query-address?' . $params;

        $timestamp = time() * 1000;
        $params_for_signature = $timestamp . $this->api_key . "5000" . $params;
        $signature = hash_hmac('sha256', $params_for_signature, $this->secret_key);

        $response = Http::withHeaders([
                "X-BAPI-API-KEY" => $this->api_key,
                "X-BAPI-SIGN" => $signature,
                "X-BAPI-SIGN-TYPE" => "2",
                "X-BAPI-TIMESTAMP" => $timestamp,
                "X-BAPI-RECV-WINDOW" => "5000",
            ])
            ->acceptJson()
            ->get($endpoint);
        return $response;
    }

    public function GetServerTime()
    {
        return Http::get('https://api.bybit.com/v5/market/time');
    }



    public function http_req($endpoint,$method,$params,$Info){
        global $api_key, $secret_key, $url, $curl;
        $timestamp = time() * 1000;
        $params_for_signature= $timestamp . $api_key . "5000" . $params;
        $signature = hash_hmac('sha256', $params_for_signature, $secret_key);
        if($method=="GET")
        {
            $endpoint=$endpoint . "?" . $params;
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => array(
                "X-BAPI-API-KEY: $api_key",
                "X-BAPI-SIGN: $signature",
                "X-BAPI-SIGN-TYPE: 2",
                "X-BAPI-TIMESTAMP: $timestamp",
                "X-BAPI-RECV-WINDOW: 5000",
                "Content-Type: application/json"
            ),
        ));
        if($method=="GET")
        {
            curl_setopt($curl, CURLOPT_HTTPGET, true);
        }
        echo $Info . "\n";
        $response = curl_exec($curl);
        echo $response . "\n";
    }

    public function getDepositHistory(string $coin, int $startTime, int $endTime)
    {
        $params = 'coin=' .$coin. '&startTime=' .$startTime. '&endTime=' .$endTime;
        $endpoint = $this->base_endpoint . '/v5/asset/deposit/query-record?' . $params;

        $timestamp = time() * 1000;
        $params_for_signature = $timestamp . $this->api_key . "5000" . $params;
        $signature = hash_hmac('sha256', $params_for_signature, $this->secret_key);

        $response = Http::withHeaders([
            "X-BAPI-API-KEY" => $this->api_key,
            "X-BAPI-SIGN" => $signature,
            "X-BAPI-SIGN-TYPE" => "2",
            "X-BAPI-TIMESTAMP" => $timestamp,
            "X-BAPI-RECV-WINDOW" => "5000",
        ])
            ->acceptJson()
            ->get($endpoint);
        return $response;
    }


}
