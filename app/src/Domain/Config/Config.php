<?php

declare(strict_types=1);

namespace Hinoho\Battleship\Domain\Config;

class Config
{
    public readonly string $rabbitHost;
    public readonly int $rabbitPort;
    public readonly string $rabbitUser;
    public readonly string $rabbitPassword;

    public readonly string $postgresHost;
    public readonly string $postgresPort;
    public readonly string $postgresDatabase;
    public readonly string $postgresUser;
    public readonly string $postgresPassword;


    public function __construct()
    {
        $this->rabbitHost = getenv('RABBIT_MQ_HOST');
        $this->rabbitPort = (int)getenv('RABBIT_MQ_PORT');
        $this->rabbitUser = getenv('RABBIT_MQ_USER');
        $this->rabbitPassword = getenv('RABBIT_MQ_PASSWORD');

        $this->postgresHost = getenv('POSTGRES_HOST');
        $this->postgresPort = getenv('POSTGRES_PORT');
        $this->postgresDatabase = getenv('POSTGRES_DATABASE');
        $this->postgresUser = getenv('POSTGRES_USER');
        $this->postgresPassword = getenv('POSTGRES_PASSWORD');
    }
}
