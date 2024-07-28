<?php

declare(strict_types=1);

namespace App\Queue\Message;

class AbstractQueueMessage implements \JsonSerializable
{
    public const QUEUE_NAME = '';

    public function __construct()
    {
        if (empty(static::QUEUE_NAME)) {
            throw new \RuntimeException('Queue name not set in ' . get_class($this));
        }
    }

    public function jsonSerialize(): mixed
    {
       return get_object_vars($this);
    }
}
