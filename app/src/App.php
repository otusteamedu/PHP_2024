<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Chat;

class App
{
    public const SERVER = 'server';
    public const CLIENT = 'client';

    public function __construct(private readonly array $argv)
    {
    }

    public function run(): void
    {
        $action = $this->argv[1] ?? null;

        match ($action) {
            self::SERVER => (new Server())->start(),
            self::CLIENT => (new Client())->start(),
            default => throw new \InvalidArgumentException(sprintf('Invalid action: %s.', $action)),
        };
    }
}
