<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Service;

use Module\News\Application\Service\Dto\Consumer;
use Module\News\Application\Service\Dto\Message;
use Module\News\Application\Service\Interface\MessageBusServiceInterface;
use Module\News\Application\UseCase\ChangeStatus\ChangeStatusUseCase;

final readonly class LaravelMessageBusService implements MessageBusServiceInterface
{
    public function __construct(
        private ChangeStatusUseCase $useCase
    ) {
    }

    public function publish(Message $message): void
    {
        Job::dispatch(new Consumer($this->useCase, $this), $message);
    }
}
