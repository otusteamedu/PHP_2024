<?php

namespace App\Application\Gateway;

readonly class UrlGatewayRequest
{
    function __construct(
        public string $url,
    )
    {
    }
}
