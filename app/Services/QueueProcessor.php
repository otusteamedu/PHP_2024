<?php

namespace App\Services;

use App\Contracts\QueueClientInterface;
use App\Contracts\QueueTaskHandlerInterface;
use App\Models\Request;
use Redis;
use RedisException;

class QueueProcessor
{
    private QueueClientInterface $queueClient;

    private array $handlers;

    public function __construct(QueueClientInterface $queueClient)
    {
        $this->queueClient = $queueClient;
        $this->handlers = [];
    }

    public function registerHandler(string $type, QueueTaskHandlerInterface $handler): void
    {
        $this->handlers[$type] = $handler;
    }

    public function processQueue(string $queueName): void
    {
        while ($task = $this->queueClient->pop($queueName)) {
            if (isset($this->handlers[$task['type']])) {
                $this->handlers[$task['type']]->handle($task['data']);
            } else {
                echo "Unknown task type: " . $task['type'] . PHP_EOL;
            }
        }
    }
}
