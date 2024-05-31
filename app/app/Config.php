<?php

declare(strict_types=1);

namespace Rmulyukov\Hw;

use InvalidArgumentException;

final class Config
{
    private readonly string $rabbitHost;
    private readonly int $rabbitPort;
    private readonly string $rabbitUsername;
    private readonly string $rabbitPassword;

    public function __construct(array $config)
    {
        $this->ensureCorrectParams($config);
        $this->rabbitHost = $config['rabbit']['host'];
        $this->rabbitPort = $config['rabbit']['port'];
        $this->rabbitUsername = $config['rabbit']['username'];
        $this->rabbitPassword = $config['rabbit']['password'];
    }

    public function getRabbitHost(): string
    {
        return $this->rabbitHost;
    }

    public function getRabbitPort(): int
    {
        return $this->rabbitPort;
    }

    public function getRabbitUsername(): string
    {
        return $this->rabbitUsername;
    }

    public function getRabbitPassword(): string
    {
        return $this->rabbitPassword;
    }

    private function ensureCorrectParams(array $config): void
    {
        if (
            !isset($config['rabbit']) ||
            !isset($config['rabbit']['host']) ||
            !isset($config['rabbit']['port']) ||
            !isset($config['rabbit']['username']) ||
            !isset($config['rabbit']['password'])
        ) {
            throw new InvalidArgumentException("Invalid rabbit configs");
        }
    }
}
