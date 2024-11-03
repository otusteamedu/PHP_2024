<?php

declare(strict_types=1);

namespace App\Application\Gateway;

class SiteGatewayRequest
{
    public function __construct(public readonly string $url)
    {
    }
}
