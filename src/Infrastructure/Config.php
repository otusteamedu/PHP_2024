<?php

namespace AKornienko\Php2024\Infrastructure;

readonly class Config
{
    public string $redisHost;
    public string $redisPort;

    public function __construct()
    {
        $this->redisHost = getenv("REDIS_HOST");
        $this->redisPort = getenv("REDIS_PORT");
    }
}
