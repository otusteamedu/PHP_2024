<?php

declare(strict_types=1);

namespace Otus\AppPDO;

class Config
{
    private $config;

    public function __construct()
    {
        $this->config = [
            'host' => getenv('POSTGRES_HOST'),
            'port' => getenv('POSTGRES_PORT'),
            'db' => getenv('POSTGRES_DB'),
            'user' => getenv('POSTGRES_USER'),
            'password' => getenv('POSTGRES_PASSWORD'),
        ];
    }

    public function getDatabaseConfig(): array
    {
        return $this->config;
    }
}
