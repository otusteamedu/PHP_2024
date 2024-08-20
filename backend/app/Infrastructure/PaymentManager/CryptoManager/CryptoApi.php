<?php

namespace App\Infrastructure\PaymentManager\CryptoManager;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

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


    public function getDepositHistory(string $coin, int $startTime, int $endTime)
    {
        $ms = '000';
        $params = 'coin=' .$coin. '&startTime=' .$startTime.$ms. '&endTime=' .$endTime.$ms;
        //$params = 'coin=' .$coin;
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
