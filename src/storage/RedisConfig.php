<?php

namespace Ahar\Hw12\storage;

use DomainException;

class RedisConfig
{
    public string $host;
    public int $port;

    public function __construct()
    {
        $host = getenv('REDIS_HOST');
        $port = getenv('REDIS_PORT');

        if (empty($host)) {
            throw new DomainException('REDIS_HOST not found in config');
        }

        if (empty($port)) {
            throw new DomainException('REDIS_PORT not found in config');
        }

        $this->host = $host;
        $this->port = (int)$port;
    }
}
