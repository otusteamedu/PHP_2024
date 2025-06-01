<?php

declare(strict_types=1);

namespace App\DI;

use Exception;

class Container
{
    /**
     * @var array<string, callable>
     */
    private array $services = [];

    /**
     * Registers a service in the container.
     *
     * @param string $id The service identifier.
     * @param callable $factory A factory function that returns the service instance.
     */
    public function set(string $id, callable $factory): void
    {
        $this->services[$id] = $factory;
    }

    /**
     * Retrieves a service from the container.
     *
     * @param string $id The service identifier.
     * @return mixed The service instance.
     * @throws Exception If the service is not found.
     */
    public function get(string $id)
    {
        if (!isset($this->services[$id])) {
            throw new Exception("Service {$id} not found");
        }

        return $this->services[$id]($this);
    }
}
