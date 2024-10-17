<?php

declare(strict_types=1);

namespace Viking311\Api\Application\UseCase\ProcessEvent;

readonly class ProcessEventResponse
{
    public function __construct(
        public string $message
    ) {
    }
}
