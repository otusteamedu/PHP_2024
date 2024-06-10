<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue;

use App\Application\Queue\QueueJobInterface;
use App\Application\Queue\Request\QueueRequest;
use App\Infrastructure\Queue\Messages\NewsMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class QueueJob implements QueueJobInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {} // phpcs:ignore

    public function push(QueueRequest $request): void
    {
        $message = new NewsMessage($request->newsId);
        $this->messageBus->dispatch($message);
    }
}
