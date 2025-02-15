<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusQueueApp\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use ErrorException;
use Dotenv;

class RabbitMQService implements QueueInterface
{
    /** @var string */
    private string $queueName;

    /** @var AMQPStreamConnection */
    private AMQPStreamConnection $connection;

    /**
     * Устанавливается соединение в методе конструктора
     */
    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->connection = new AMQPStreamConnection(
            $_ENV['RABBITMQ_HOST'],
            $_ENV['RABBITMQ_PORT'],
            $_ENV['RABBITMQ_USER'],
            $_ENV['RABBITMQ_PASSWORD']
        );

        $this->queueName = $dotenv['RABBITMQ_QUEUE_NAME'];
    }

    /**
     * Метод отправляет сообщение в очередь
     *
     * @param array $data
     *
     * @return void
     */
    public function sendMessage(array $data): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare(queue: $this->queueName, durable: true, auto_delete: false);

        $message = new AMQPMessage(json_encode($data), ['delivery_mode' => 2]);
        $channel->basic_publish(msg: $message, routing_key: $this->queueName);

        $channel->close();
    }

    /**
     * Метод получает сообщения из очереди
     *
     * @param callable $callback
     * @return void
     *
     * @throws ErrorException
     */
    public function consumeMessages(callable $callback): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare(queue: $this->queueName, durable: true, auto_delete: false);

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume(queue: $this->queueName, callback: function ($msg) use ($callback) {
            $data = json_decode($msg->body, true);
            $callback($data);
            $msg->ack();
        });

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
    }

    /**
     * Метод закрывает соединение с RabbitMQ
     */
    public function __destruct()
    {
        $this->connection->close();
    }
}
