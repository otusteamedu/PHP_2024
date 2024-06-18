<?php

declare(strict_types=1);

namespace Kagirova\Hw14\Domain;

class Config
{
    private readonly string $host;
    private readonly string $port;
    private readonly string $user;
    private readonly string $password;

    public function __construct()
    {
        $this->host = getenv('ES_HOST');
        $this->port = getenv('ES_PORT');
        $this->user = getenv('ES_USER');
        $this->password = getenv('ES_PASSWORD');
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): string
    {
        return $this->port;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
