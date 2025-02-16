<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Application\Gateway;

interface RedisGatewayInterface
{
    /**
     * Метод добавляет Event в Redis
     *
     * @param RedisGatewayRequest $request
     *
     * @return RedisGatewayResponse
     */
    public function saveEvent(RedisGatewayRequest $request): RedisGatewayResponse;
}
