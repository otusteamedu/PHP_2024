<?php

namespace Ahor\Hw19\rabbit;

readonly class Config
{
    public function __construct(public int $port, public string $password, public string $user, public string $host)
    {
    }

    public static function build(): Config
    {
        return new self((int)getenv('RABBITMQ_PORT'), getenv('RABBITMQ_PASSWORD'), getenv('RABBITMQ_USER'), getenv('RABBITMQ_HOST'));
    }

}
