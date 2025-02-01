<?php
namespace Src\Infrastructure\Utils;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Src\Domain\Interface\ConsumerInterface;

class Consumer implements ConsumerInterface
{
    private AMQPStreamConnection $connection;

    /**
     * @throws \Exception
     */
    public function exec(string $queue_name, callable $callback): void
    {
        $this->connection = new AMQPStreamConnection(
            getenv('RABBIT_HOST'),
            getenv('RABBIT_PORT'),
            getenv('RABBIT_USER'),
            getenv('RABBIT_PASSWORD')
        );

        $channel = $this->connection->channel();

        $channel->queue_declare($queue_name, false, false, false, false);

        $channel->basic_consume($queue_name, '', false, true, false, false, $callback);

        try {
            $channel->consume();
        } catch (\Throwable $exception) {
            throw new \Exception('consumer error');
        }
    }
}