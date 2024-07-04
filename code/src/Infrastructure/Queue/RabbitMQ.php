<?php

namespace App\Infrastructure\Queue;

use App\Application\DTO\DTO;
use App\Application\Interface\QueueAddMsgInterface;
use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQ implements QueueAddMsgInterface
{
    private AMQPStreamConnection $connection;
    private string $queueName;

    /**
     * @throws Exception
     */
    public function __construct(
        string $host,
        string $port,
        string $user,
        string $password,
        string $queueName
    ){
        $this->queueName = $queueName;
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
    }

    /**
     * @throws Exception
     */
    public function add(DTO $request): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($this->queueName, false, false, false, null);
        $messageBody = new AMQPMessage($request->request);
        $channel->basic_publish($messageBody, '', $this->queueName);
        $channel->close();
        $this->connection->close();
    }
}