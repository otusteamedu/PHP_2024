<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\UseCase\Consume;

use Rmulyukov\Hw\Application\Consumer\Consumer;
use Rmulyukov\Hw\Application\Service\MessageBusServiceInterface;

final class ConsumeUseCase
{
    private string $queue = 'hw-queue';

    public function __construct(
        private readonly MessageBusServiceInterface $messageBusService
    ) {
    }

    public function __invoke(): void
    {
        $this->messageBusService->consume(new Consumer($this->queue));
    }
}
