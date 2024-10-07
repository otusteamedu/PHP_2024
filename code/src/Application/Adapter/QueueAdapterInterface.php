<?php

declare(strict_types=1);

namespace Viking311\Queue\Application\Adapter;

interface QueueAdapterInterface
{
    /**
     * @param string $message
     * @return void
     */
    public function send(string $message): void;

    /**
     * @return string
     */
    public function receive(): string;
}
