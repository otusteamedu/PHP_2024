<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Config;

class Config
{
    private readonly string $host;
    private readonly int $port;
    private readonly string $user;
    private readonly string $password;

    public function configRabbitMQ()
    {
        $this->host = getenv('RABBIT_MQ_HOST');
        $this->port = (int)getenv('RABBIT_MQ_PORT');
        $this->user = getenv('RABBIT_MQ_USER');
        $this->password = getenv('RABBIT_MQ_PASSWORD');
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
