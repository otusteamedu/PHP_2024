<?php

declare(strict_types=1);

namespace Kagirova\Hw31\Infrastucture\Service;

use Kagirova\Hw31\Domain\Config\Config;
use Kagirova\Hw31\Domain\RepositoryInterface\StorageInterface;
use Kagirova\Hw31\Domain\Service\RabbitMqServiceInterface;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqService implements RabbitMqServiceInterface
{
    private AMQPStreamConnection $connection;
    private AbstractChannel $channel;

    public function __construct(private string $queue, Config $config)
    {
        $this->connection = new AMQPStreamConnection(
            host: $config->rabbitHost,
            port: $config->rabbitPort,
            user: $config->rabbitUser,
            password: $config->rabbitPassword
        );

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queue, false, false, false, false);
    }

    public function publish($message, $messgaeID)
    {
        $message = new AMQPMessage($this->toAMPQMessage($message), ['message_id' => $messgaeID]);
        return $this->channel->basic_publish($message, '', $this->queue);
    }

    public function consume(StorageInterface $storage)
    {
        $callback = function ($message) use ($storage) {
            $storage->updateStatus((int)$message->get('message_id'), 3);
        };

        while (true) {
            $this->channel->basic_consume($this->queue, '', false, true, false, false, $callback);
            try {
                $this->channel->consume();
            } catch (\Throwable $exception) {
                echo $exception->getMessage();
            }
        }
    }

    public function toAMPQMessage($data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR, 512);
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
