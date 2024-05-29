<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\UseCase\Publish;

use Rmulyukov\Hw\Application\DTO\Message;
use Rmulyukov\Hw\Application\Service\MessageBusServiceInterface;

final class PublishUseCase
{
    private string $queue = 'hw-queue';

    public function __construct(
        private readonly MessageBusServiceInterface $messageBusService
    ) {
    }

    public function __invoke(PublishRequest $request): void
    {
        $this->messageBusService->publish(
            new Message($this->queue, $request->message, $request->email)
        );
    }
}
