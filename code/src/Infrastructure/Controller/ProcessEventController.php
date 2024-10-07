<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Controller;

use Viking311\Queue\Application\UseCase\ProcessEvent\ProcessEventUseCase;

readonly class ProcessEventController
{
    public function __construct(
        private ProcessEventUseCase $useCase
    ){
    }

    public function execute(): void
    {
        while(true) {
            $response  = ($this->useCase)();

            echo ' [x] Received '. $response->message . PHP_EOL;
        }
    }


}
