<?php

namespace App\Application\Gateway;

readonly class UrlGatewayRequest
{
    public function __construct(
        public string $url,
    ) {
    }
}
