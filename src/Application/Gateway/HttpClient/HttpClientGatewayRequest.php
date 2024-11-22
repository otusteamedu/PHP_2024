<?php

namespace App\Application\Gateway\HttpClient;

use App\Domain\ValueObject\Url;

class HttpClientGatewayRequest
{
    public function __construct(
        public readonly Url $url,
    ) {
    }
}
