<?php

namespace App\Contracts;

interface QueueClientInterface {
    public function connect(string $host, int $port): void;
    public function push(string $queue, $data): void;
    public function pop(string $queue): ?array;
}
