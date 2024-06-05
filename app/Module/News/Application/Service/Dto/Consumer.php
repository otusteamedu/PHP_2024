<?php

declare(strict_types=1);

namespace Module\News\Application\Service\Dto;

use Module\News\Application\Service\Interface\MessageBusServiceInterface;
use Module\News\Application\UseCase\ChangeStatus\ChangeStatusRequest;
use Module\News\Application\UseCase\ChangeStatus\ChangeStatusUseCase;

use function sleep;

final class Consumer
{
    private array $statusesSequence = [
        'processing' => 'approving',
        'approving' => 'published'
    ];

    public function __construct(
        private readonly ChangeStatusUseCase $useCase,
        private readonly MessageBusServiceInterface $messageBus,
    ) {
    }

    public function handle(Message $message): void
    {
        ($this->useCase)(new ChangeStatusRequest($message->newsId, $message->status));

        sleep(20);

        if ($nextStatus = $this->statusesSequence[$message->status] ?? null) {
            $this->messageBus->publish(new Message($message->newsId, $nextStatus));
        }
    }
}
