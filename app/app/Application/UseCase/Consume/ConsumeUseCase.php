<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\UseCase\Consume;

use Rmulyukov\Hw\Application\Consumer\Consumer;
use Rmulyukov\Hw\Application\Service\MessageBusServiceInterface;

final readonly class ConsumeUseCase
{
    public function __construct(
        private MessageBusServiceInterface $messageBusService
    ) {
    }

    public function __invoke(): void
    {
        $this->messageBusService->consume(new Consumer());
    }
}
