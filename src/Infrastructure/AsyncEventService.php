<?php

namespace AKornienko\Php2024\Infrastructure;

use AKornienko\Php2024\Application\HandleAsyncEvents\AsyncEventRepository;

class AsyncEventService implements AsyncEventRepository
{
    private RabbitClient $client;

    public function __construct(RabbitClient $rabbitClient)
    {
        $this->client = $rabbitClient;
    }

    public function listenAsyncEvents(callable $callback): void
    {
        $this->client->listenQueue($callback);
    }
}
