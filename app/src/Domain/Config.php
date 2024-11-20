<?php

declare(strict_types=1);

namespace Kagirova\Hw14\Domain;

class Config
{
    public readonly string $host;
    public readonly string $port;
    public readonly string $user;
    public readonly string $password;

    public function __construct()
    {
        $this->host = getenv('ES_HOST');
        $this->port = getenv('ES_PORT');
        $this->user = getenv('ES_USER');
        $this->password = getenv('ES_PASSWORD');
    }
}
