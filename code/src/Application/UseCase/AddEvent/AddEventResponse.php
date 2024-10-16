<?php

declare(strict_types=1);

namespace Viking311\Api\Application\UseCase\AddEvent;

use OpenApi\Attributes as OA;

#[OA\Schema]
class AddEventResponse
{
    public function __construct(
        #[OA\Property]
        public string $eventId
    ) {
    }
}
