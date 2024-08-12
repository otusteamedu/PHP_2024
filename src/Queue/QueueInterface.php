<?php

declare(strict_types=1);

namespace App\Queue;

use App\Queue\Message\AbstractQueueMessage;
use Iterator;

;

interface QueueInterface
{
    public function push(AbstractQueueMessage $message): void;
    public function pull(string $queueName, callable $callback): void;

    /**
     * @param string $queueName
     * @return Iterator<array>
     */
    public function getMessages(string $queueName): Iterator;
}
