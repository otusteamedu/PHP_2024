<?php

namespace App\Application\Gateway;

readonly class UrlGatewayResponse
{
    public function __construct(
        public string $title,
    ) {
    }
}
