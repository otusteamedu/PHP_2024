<?php

namespace Producer\Service;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class RabbitMQService
{
    private const QUEUE_NAME = 'otus_queue';

    private readonly AMQPStreamConnection $connection;
    private readonly AMQPChannel $channel;
    private readonly LoggerInterface $logger;

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly string $host,
        private readonly int $port,
        private readonly string $user,
        private readonly string $password,
        LoggerInterface $logger
    ){
        $this->logger = $logger;
        $this->connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->password);
        $this->channel = $this->connection->channel();
    }

    /**
     * @throws Exception
     */
    public function sendMessage(string $data): void
    {
        try {
            $this->channel->queue_declare(self::QUEUE_NAME, false, true, false, false);

            $message = new AMQPMessage($data, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
            $this->channel->basic_publish($message, '', self::QUEUE_NAME);

            $this->logger->info('Message sent to queue', ['queue' => self::QUEUE_NAME, 'message' => $data]);
        } catch (\Exception $e) {
            $this->logger->error('Failed to send message', ['error' => $e->getMessage()]);
            throw $e;
        } finally {
            $this->closeConnection();
        }
    }

    /**
     * @throws Exception
     */
    private function closeConnection(): void
    {
        $this->channel?->close();
        $this->connection?->close();
    }
}
