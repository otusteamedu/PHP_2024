<?php

namespace App\Application\Gateway\HttpClient;

use App\Infrastructure\Gateway\HttpClient\HttpClientGatewayRequest;
use App\Infrastructure\Gateway\HttpClient\HttpClientGatewayResponse;

interface HttpClientGatewayInterface
{
    public function __invoke(HttpClientGatewayRequest $request): HttpClientGatewayResponse;
}
