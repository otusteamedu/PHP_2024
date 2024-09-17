<?php

declare(strict_types=1);

namespace App\Application\Gateway;

class NewsGatewayRequest
{
    public function __construct(
        public readonly string $url,
    ) {
    }
}