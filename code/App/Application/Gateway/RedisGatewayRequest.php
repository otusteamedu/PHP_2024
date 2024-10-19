<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Domain\Entity\Event;

class RedisGatewayRequest
{
    public Event $event;
    public function __construct(
        Event $event
    )
    {
        $this->event = $event;
    }
}