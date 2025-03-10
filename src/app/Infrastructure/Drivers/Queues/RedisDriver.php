<?php

declare(strict_types=1);

namespace App\Infrastructure\Drivers\Queues;

use App\Application\Contracts\QueueDriverInterface;
use Predis\Client;

readonly class RedisDriver implements QueueDriverInterface
{
    private Client $client;

    public function __construct(array $config, private string $queueName = 'default_queue')
    {
        $this->client = new Client($config['redis']);
    }

    public function sendMessage(string $message): void
    {
        $this->client->rpush($this->queueName, [$message]);
    }

    public function receiveMessage(callable $callback): void
    {
        while (true) {
            $message = $this->client->blpop($this->queueName, 0);

            if ($message) {
                $callback($message[0]);
            }
        }
    }
}
