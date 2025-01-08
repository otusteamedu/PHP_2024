<?php

namespace VladimirGrinko\Rabbit\App\Queue;

interface QueueInterface
{
    public function sendMessage(array $data): void;
    public function consumeMessages(callable $callback): void;
}
