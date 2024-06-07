<?php

namespace AKornienko\Php2024\Infrastructure;

readonly class Config
{
    public string $rabbitHost;
    public string $rabbitPort;
    public string $rabbitUser;
    public string $rabbitPassword;

    public function __construct()
    {
        $this->rabbitHost = getenv("RABBIT_HOST");
        $this->rabbitPort = getenv("RABBIT_PORT");
        $this->rabbitUser = getenv("RABBIT_USER");
        $this->rabbitPassword = getenv("RABBIT_PASSWORD");
    }
}
