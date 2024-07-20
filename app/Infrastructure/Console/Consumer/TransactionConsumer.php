<?php

namespace App\Infrastructure\Console\Consumer;

use App\Domain\Contract\ConsumerCallbackInterface;
use App\Domain\Contract\ConsumerInterface;
use App\Infrastructure\Console\RabbitConnection;

class TransactionConsumer implements ConsumerInterface
{
    private string $queue = 'transaction';
    public function __construct(
        private readonly RabbitConnection $connection,
        private readonly ConsumerCallbackInterface $callback
    )
    {
    }

    private function queueDeclare(): void
    {
        $this->connection
            ->channel()
            ->queue_declare(
                $this->queue,
                false,
                false,
                false,
                false
            );
    }

    private function setBasic(): void
    {
        $this->connection->channel()->basic_consume(
            $this->queue,
                '',
                false,
                true,
                false,
                false,
            $this->callback
            );
    }
}