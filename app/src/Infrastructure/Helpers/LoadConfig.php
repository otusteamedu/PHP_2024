<?php

declare(strict_types=1);

namespace App\Infrastructure\Helpers;

class LoadConfig
{
    private readonly string $host;
    private readonly int $port;
    private readonly string $user;
    private readonly string $password;

    public function __construct()
    {
        $this->host = getenv('RABBIN_HOST');
        $this->port = (int)getenv('RABBIT_PORT');
        $this->user = getenv('RABBIT_USER');
        $this->password = getenv('RABBIT_PASSWORD');

        if (!$this->host) {
            throw new \DomainException("No isset RABBIN_HOST in .env");
        }

        if (!$this->port) {
            throw new \DomainException("No isset RABBIT_PORT in .env");
        }

        if (!$this->user) {
            throw new \DomainException("No isset RABBIT_USER in .env");
        }

        if (!$this->password) {
            throw new \DomainException("No isset RABBIT_PASSWORD in .env");
        }
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
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
