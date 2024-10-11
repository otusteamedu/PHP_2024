<?php

declare(strict_types=1);

namespace Viking311\Api\Application\UseCase\AddEvent;

class AddEventResponse
{
    public function __construct(
        public string $eventId
    ) {
    }

}
