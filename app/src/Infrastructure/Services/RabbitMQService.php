<?php

declare(strict_types=1);

namespace App\Infrastructure\Services;

use App\Application\Services\QueueInterface;
use App\Domain\Entity\BankStatement;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use App\Infrastructure\Helpers\LoadConfig;

class RabbitMQService implements QueueInterface
{
    private const QUEUE = "hw20";
    protected AMQPStreamConnection $connection;
    

    public function __construct(LoadConfig $config)
    {
        try {
            $connection = new AMQPStreamConnection(
                $config->getHost(),
                $config->getPort(),
                $config->getUser(),
                $config->getPassword()
            );
            $connection->channel = $connection->channel();
            $connection->channel->queue_declare(self::QUEUE, false, false, false, false);
            $this->connection = $connection;
        } catch (\Exception $exception) {
            throw new \Exception("Error connection to RabbitMQ: " . $exception->getMessage());
        }
    }

    public function addMessage(BankStatement $message): void
    {
        try {
            $messageRabbit = new AMQPMessage(json_encode($message), array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
            $this->connection->channel->basic_publish($messageRabbit, '', self::QUEUE);
            $this->connection->channel->close();
            $this->connection->close();
        } catch (\Exception $exception) {
            throw new \Exception("Error sendMessage to RabbitMQ: " . $exception->getMessage());
        }
    }

    public function getMessage(callable $callback): void
    {
        #$this->connection->channel->basic_qos(null, 1, null);
        $this->connection->channel->basic_consume(self::QUEUE, '', false, false, false, false, $callback);

        while ($this->connection->channel->is_consuming()) {
            $this->connection->channel->wait();
        }

        $this->connection->channel->close();
        $this->connection->close();
    }
}
