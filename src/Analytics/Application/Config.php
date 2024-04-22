<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application;

use AlexanderGladkov\Analytics\Config\BaseConfig;
use AlexanderGladkov\Analytics\Config\ConfigFileReadException;
use AlexanderGladkov\Analytics\Config\ConfigValidationException;

class Config extends BaseConfig
{
    private readonly string $host;
    private readonly int $port;
    private readonly string $password;

    /**
     * @param $filename
     * @throws ConfigFileReadException
     * @throws ConfigValidationException
     */
    public function __construct($filename)
    {
        parent::__construct($filename);
        $this->validate();
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return void
     * @throws ConfigValidationException
     */
    private function validate(): void
    {
        $this->readSection('redis', [
            'host',
            'port',
            'password'
        ]);
    }
}
