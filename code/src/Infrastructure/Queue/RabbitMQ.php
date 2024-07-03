<?php

namespace App\Infrastructure\Queue;

use App\Application\Interface\QueueAddMsgInterface;
use App\Domain\Entity\StatementRequest;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQ implements QueueAddMsgInterface
{
    private AMQPStreamConnection $connection;

    public function __construct(
        string $host,
        int $port,
        string $user,
        string $password
    ){
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
    }

    public function add(StatementRequest $request): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare('statement_request_queue', false, false, false, null);
        $messageBody = new AMQPMessage($request);
        $channel->basic_publish($messageBody, '', 'statement_request_queue');
        $channel->close();
    }

    public function closeConnection(): void
    {
        $this->connection->close();
    }
}