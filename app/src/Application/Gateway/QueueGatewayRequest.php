<?php

declare(strict_types=1);

namespace App\Application\Gateway;

class QueueGatewayRequest
{
    public function __construct(public readonly int $id)
    {
    }
}
