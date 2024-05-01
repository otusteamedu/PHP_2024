<?php

declare(strict_types=1);

namespace AShutov\Hw15;

readonly class Config
{
    public string $redisHost;
    public int $redisPort;
    public string $redisPassword;

    public function __construct()
    {
        $this->redisHost = $_ENV["REDIS_HOST"];
        $this->redisPort = (int) $_ENV["REDIS_PORT"];
        $this->redisPassword = $_ENV["REDIS_PASSWORD"];
    }
}
