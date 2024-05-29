<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Infrastructure\Service;

use ErrorException;
use Exception;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Rmulyukov\Hw\Application\DTO\Message;
use Rmulyukov\Hw\Application\Consumer\Consumer;
use Rmulyukov\Hw\Application\Service\MessageBusServiceInterface;

use function json_decode;

final class RabbitMessageBusService implements MessageBusServiceInterface
{
    private AMQPStreamConnection $connection;
    private AbstractChannel|AMQPChannel $channel;

    /**
     * @throws Exception
     */
    public function __construct(string $host, int $port, string $username, string $password)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $username, $password);
        $this->channel = $this->connection->channel();
    }

    public function publish(Message $message): void
    {
        $this->channel->queue_declare($message->queue, auto_delete: false);
        $queueMessage = new AMQPMessage((string) $message);
        $this->channel->basic_publish($queueMessage, routing_key: $message->queue);
    }

    /**
     * @throws ErrorException
     */
    public function consume(Consumer $listener): void
    {
        $callback = static function (AMQPMessage $message) use ($listener): void {
            $body = json_decode($message->getBody());
            $listener->handle(new Message($listener->queue, $body->message, $body->email));
        };
        $this->channel->queue_declare($listener->queue, auto_delete: false);
        $this->channel->basic_consume($listener->queue, no_ack: true, callback: $callback);
        $this->channel->consume();
    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
