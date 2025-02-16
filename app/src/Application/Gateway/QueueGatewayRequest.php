<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Application\Gateway;

use SlavaMakhov\OtusArchitectureApp\Domain\Entity\Event;

class QueueGatewayRequest
{
    /**
     *  Метод DTO (Request) для очереди
     *
     * @param Event $event
     */
    public function __construct(
        public readonly Event $event
    )
    {
    }
}
