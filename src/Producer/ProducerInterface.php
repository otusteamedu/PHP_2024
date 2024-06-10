<?php

declare(strict_types=1);

namespace App\Producer;

interface ProducerInterface
{
    public function publish(array $msgBody, string $queueName): void;
}
