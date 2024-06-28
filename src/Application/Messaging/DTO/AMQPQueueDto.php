<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\Messaging\DTO;

readonly class AMQPQueueDto
{
    public function __construct(
        public string $queueName,
        public bool $passive = false,
        public bool $durable = false,
        public bool $exclusive = false,
        public bool $auto_delete = true,
    ) {
    }
}
