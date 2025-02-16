<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Application\Gateway;

use SlavaMakhov\OtusArchitectureApp\Domain\Entity\Event;

class RedisGatewayRequest
{
    /**
     *  Метод DTO (Request) для Redis
     *
     * @param Event $event
     */
    public function __construct(public readonly Event $event)
    {
    }
}
