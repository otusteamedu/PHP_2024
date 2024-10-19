<?php

declare(strict_types=1);

namespace App\Application\Gateway;

interface RedisGatewayInterface
{
    public function saveEvent(RedisGatewayRequest $request): RedisGatewayResponse;
}