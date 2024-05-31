<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\UseCase\Publish;

use Rmulyukov\Hw\Application\DTO\Message;
use Rmulyukov\Hw\Application\Service\MessageBusServiceInterface;

final readonly class PublishUseCase
{
    public function __construct(
        private MessageBusServiceInterface $messageBusService
    ) {
    }

    public function __invoke(PublishRequest $request): void
    {
        $this->messageBusService->publish(
            new Message($request->message, $request->email)
        );
    }
}
