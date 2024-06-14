<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Infrastucture\Service;

use Kagirova\Hw21\Domain\Config\Config;
use Kagirova\Hw21\Domain\Service\RabbitMqServiceInterface;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqService implements RabbitMqServiceInterface
{
    private AMQPStreamConnection $connection;
    private AbstractChannel $channel;
    private string $telegramChatId;
    private string $telegramToken;

    public function __construct(private string $queue, Config $config, private TelegramService $telegramService)
    {
        $this->connection = new AMQPStreamConnection(
            host: $config->getHost(),
            port: $config->getPort(),
            user: $config->getUser(),
            password: $config->getPassword()
        );

        $this->telegramChatId = $config->getTelegramChatId();
        $this->telegramToken = $config->getTelegramToken();

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queue, false, false, false, false);
    }

    public function publish($msg)
    {
        $msg = new AMQPMessage($this->toAMPQMessage($msg));
        $this->channel->basic_publish($msg, '', $this->queue);
    }

    public function consume()
    {
        $callback = function ($message) {
            $messageJson = json_decode($message->body);
            $data = $messageJson->data;
            $this->telegramService->sendMessage($data, $this->telegramChatId, $this->telegramToken);
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
