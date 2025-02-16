<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Application\Gateway;

class RedisGatewayResponse
{
    /**
     * Метод DTO (Response) для Redis
     *
     * @param int $id
     */
    public function __construct(
        public readonly int $id
    )
    {
    }
}
