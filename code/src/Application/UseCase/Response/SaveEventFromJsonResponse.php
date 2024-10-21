<?php

declare(strict_types=1);

namespace IraYu\Hw12\Application\UseCase\Response;

use IraYu\Hw12\Domain\Entity;

class SaveEventFromJsonResponse
{
    public function __construct(
        public Entity\Event $event,
    ) {
    }
}
