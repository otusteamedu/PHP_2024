<?php

namespace App\Infrastructure\Gateway\HttpClient;

use App\Domain\ValueObject\Url;

class HttpClientGatewayRequest
{
    public function __construct(
        public readonly Url $url,
    ) {
    }
}
