<?php

namespace Src\Domain\Interface;

interface ConsumerInterface
{
    public function exec(string $queue_name, callable $callback): void;
}
