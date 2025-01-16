<?php

declare(strict_types=1);

namespace App\Banking\Queue;

interface PublisherInterface
{
    /**
     * @throws \Exception
     */
    public function publish(string $messageBody): void;

    public function getQueueName(): string;

    public function getExchangeName(): string;
}
