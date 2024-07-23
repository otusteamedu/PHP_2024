<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Consumer;

use App\Domain\Contract\ConsumerCallbackInterface;
use App\Domain\Contract\ConsumerInterface;
use App\Infrastructure\Console\QueueConnection;
use ErrorException;

class TransactionConsumer implements ConsumerInterface
{
    private string $queue = 'transaction';
    public function __construct(
        private readonly QueueConnection $connection,
        private readonly ConsumerCallbackInterface $callback
    )
    {
        $this->queueDeclare();
        $this->setBasic();
    }

    /**
     * @throws ErrorException
     */
    public function consume(): void
    {
        $this->connection->channel()->consume();
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