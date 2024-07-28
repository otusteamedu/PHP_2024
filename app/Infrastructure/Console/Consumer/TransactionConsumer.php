<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Consumer;

use App\Domain\Contract\ConsumerInterface;
use App\Infrastructure\Console\Callback\TransactionReportCallback;
use App\Infrastructure\Console\QueueConnection;
use ErrorException;
use PhpAmqpLib\Channel\AMQPChannel;

class TransactionConsumer implements ConsumerInterface
{
    private string $queue = 'transaction';
    private ?AMQPChannel $channel = null;
    public function __construct(
        private readonly QueueConnection $connection,
        private readonly TransactionReportCallback $callback
    )
    {
        $this->channel = $this->connection->channel();
        $this->queueDeclare();
        $this->setBasic();

    }

    /**
     * @throws ErrorException
     */
    public function consume(): void
    {
        $this->channel->consume();
    }

    private function queueDeclare(): void
    {
        $this->channel
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
        $this->channel->basic_consume(
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
