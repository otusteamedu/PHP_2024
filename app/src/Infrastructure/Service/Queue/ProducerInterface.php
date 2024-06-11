<?php

namespace App\Infrastructure\Service\Queue;

interface ProducerInterface
{
    public function publish(string $message): void;
}
