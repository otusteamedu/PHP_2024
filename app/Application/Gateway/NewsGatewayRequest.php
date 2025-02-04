<?php

namespace App\Application\Gateway;

class NewsGatewayRequest
{
    public function __construct(
        public readonly string $url,
    )
    {
    }

}
