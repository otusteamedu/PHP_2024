<?php

declare(strict_types=1);

namespace Apeskovatzkov\Hw5;

use Apeskovatzkov\Hw5\Application\Configurator;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services = [];

    public function __construct()
    {
        $this->services = [
            'server' => fn () => new Server(configurator: $this->get('config')),
            'client' => fn () => new Client(configurator: $this->get('config')),
            'config' => fn () => new Configurator(),
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
