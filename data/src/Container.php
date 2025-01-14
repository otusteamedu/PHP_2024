<?php

declare(strict_types=1);

namespace Apeskovatzkov\Hw5;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services = [];

    public function __construct()
    {
        $this->services = [
            'server' => fn () => new Server(),
            'client' => fn () => new Client(),
        ];
    }

    public function get(string $id)
    {
        return $this->services[$id]();
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }
}