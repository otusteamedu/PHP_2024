<?php

namespace App\Infrastructure\Consumer;

use App\Application\Consumer\ConsumerInterface;
use App\Infrastructure\RabbitClient;

class Consumer implements ConsumerInterface
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
