<?php

namespace App\Application\Consumer;

interface ConsumerInterface
{
    public function listenToQueue(callable $callback): void;
}
