<?php

namespace AnatolyShilyaev\App\Infrastructure;

readonly class Config
{
    public string $host;
    public string $port;
    public string $user;
    public string $password;

    public function __construct()
    {
        $this->host = getenv("RABBIT_HOST");
        $this->port = getenv("RABBIT_PORT");
        $this->user = getenv("RABBIT_USER");
        $this->password = getenv("RABBIT_PASSWORD");
    }
}
