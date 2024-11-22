<?php

namespace App\Infrastructure\Gateway\HttpClient;

class HttpClientGatewayResponse
{
    public function __construct(
        public readonly string $title,
    ) {
    }
}
