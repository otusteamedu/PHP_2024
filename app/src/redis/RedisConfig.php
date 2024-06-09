<?php

declare(strict_types=1);

namespace Dsergei\Hw12\redis;

use DomainException;

readonly class RedisConfig
{
    public string $host;
    public int $port;

    public function __construct()
    {
        $host = getenv('REDIS_HOST');
        $port = getenv('REDIS_PORT');

        if (empty($host)) {
            throw new DomainException('Host not defined');
        }

        if (empty($port)) {
            throw new DomainException('Port not defined');
        }

        $this->host = $host;
        $this->port = (int)$port;
    }
}
