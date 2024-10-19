<?php

declare(strict_types=1);

namespace App\Application\Gateway;

class RedisGatewayResponse
{
    public int $id;
    public function __construct(
        int $id
    )
    {
        $this->id = $id;
    }
}