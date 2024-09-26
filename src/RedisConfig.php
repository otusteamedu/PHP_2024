<?php

declare(strict_types=1);

namespace Afilipov\Hw12;

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
            throw new DomainException('REDIS_HOST не заполнен');
        }

        if (empty($port)) {
            throw new DomainException('REDIS_PORT не заполнен');
        }

        $this->host = $host;
        $this->port = (int)$port;
    }
}
