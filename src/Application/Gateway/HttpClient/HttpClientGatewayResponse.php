<?php

namespace App\Application\Gateway\HttpClient;

class HttpClientGatewayResponse
{
    public function __construct(
        public readonly string $title,
    ) {
    }
}
