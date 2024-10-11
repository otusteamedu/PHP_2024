<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Command;

use Viking311\Api\Application\UseCase\ProcessEvent\ProcessEventUseCase;

readonly class ProcessEventCommand
{
    public function __construct(
        private ProcessEventUseCase $useCase
    ) {
    }

    public function execute(): void
    {
        while (true) {
            $response = ($this->useCase)();

            echo ' [x] Received ' . $response->message . PHP_EOL;
        }
    }
}
