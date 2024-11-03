<?php

declare(strict_types=1);

namespace App\Application\Gateway;

class SiteGatewayResponse
{
    public function __construct(public readonly string $html)
    {
    }
}
