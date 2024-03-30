<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Infrastructure\Repository\Redis;

use Redis;

abstract readonly class AbstractRedisRepository
{
    protected Redis $client;

    public function __construct(
        protected string $host,
        protected int $port,
    ) {
        $this->client = new Redis();
    }
}
