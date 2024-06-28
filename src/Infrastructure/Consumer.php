<?php

namespace App\Infrastructure;

use App\Infrastructure\CustomerTask\CustomerTaskDataMapper;

class Consumer
{
    private RabbitClient $client;
    private CustomerTaskDataMapper $customerTaskDataMapper;

    public function __construct(
        RabbitClient $rabbitClient,
        CustomerTaskDataMapper $customerTaskDataMapper
    ) {
        $this->client = $rabbitClient;
        $this->customerTaskDataMapper = $customerTaskDataMapper;
    }

    /**
     * @throws \ErrorException
     */
    public function listenQueue(): void
    {
        $callback = function ($msg) {
            $task = json_decode($msg->body, true);
            $this->customerTaskDataMapper->updateStatus($task['id']);
            print_r(PHP_EOL . ' [x] Received ' . $msg->body . PHP_EOL);
        };
        $this->client->listenQueue($callback);
    }
}
