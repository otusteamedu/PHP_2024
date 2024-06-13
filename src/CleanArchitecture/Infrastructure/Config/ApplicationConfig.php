<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Config;

class ApplicationConfig
{
    public function getDbHost(): string
    {
        return getenv('POSTGRES_HOST');
    }

    public function getDbPort(): string
    {
        return getenv('POSTGRES_PORT');
    }

    public function getDbName(): string
    {
        return getenv('POSTGRES_DB');
    }

    public function getDbUser(): string
    {
        return getenv('POSTGRES_USER');
    }

    public function getDbPassword(): string
    {
        return getenv('POSTGRES_PASSWORD');
    }
}
