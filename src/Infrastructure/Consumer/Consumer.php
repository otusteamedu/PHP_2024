<?php

namespace SergeyShirykalov\HomeworkRabbit\Infrastructure\Consumer;

use SergeyShirykalov\HomeworkRabbit\Application\Consumer\ConsumerInterface;
use SergeyShirykalov\HomeworkRabbit\Infrastructure\RabbitClient;

readonly class Consumer implements ConsumerInterface
{
    public function __construct(
        private RabbitClient $rabbitClient,
    )
    {
    }

    /**
     * @param callable $callback
     * @return void
     * @throws \ErrorException
     */
    public function listenToQueue(callable $callback): void
    {
        $this->rabbitClient->consume($callback);
    }
}